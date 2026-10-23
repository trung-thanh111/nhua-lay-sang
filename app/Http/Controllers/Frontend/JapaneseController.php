<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JapaneseLesson;
use App\Models\JapaneseVocabulary;
use App\Models\JapaneseGrammar;
use App\Models\JapaneseKanji;
use App\Models\JapaneseJlptQuestion;
use App\Models\JapaneseSrsCard;

class JapaneseController extends Controller
{
    /**
     * Trang chủ học tiếng Nhật: Tổng quan Minna, Kanji, Ngữ pháp, JLPT
     */
    public function index()
    {
        $lessons = JapaneseLesson::where('publish', 2)
            ->orderBy('lesson_number', 'asc')
            ->get();

        $kanjiCount = JapaneseKanji::count();
        $vocabCount = JapaneseVocabulary::count();
        $grammarCount = JapaneseGrammar::count();
        $questionCount = JapaneseJlptQuestion::count();

        return view('frontend.japanese.index', compact('lessons', 'kanjiCount', 'vocabCount', 'grammarCount', 'questionCount'));
    }

    /**
     * Chi tiết bài học Minna no Nihongo (Từ vựng, Ngữ pháp, Kaiwa)
     */
    public function lesson($code)
    {
        $lesson = JapaneseLesson::with(['vocabularies', 'grammars'])
            ->where('code', $code)
            ->where('publish', 2)
            ->firstOrFail();

        $allLessons = JapaneseLesson::where('publish', 2)
            ->orderBy('lesson_number', 'asc')
            ->get();

        return view('frontend.japanese.lesson', compact('lesson', 'allLessons'));
    }

    /**
     * Danh mục Kanji & Tra cứu chữ Hán theo Level / Nét
     */
    public function kanji(Request $request)
    {
        $level = $request->get('level', 'N5');
        $query = JapaneseKanji::query();

        if ($level !== 'all') {
            $query->where('level', $level);
        }

        if ($keyword = $request->get('keyword')) {
            $query->where(function($q) use ($keyword) {
                $q->where('character', 'like', "%{$keyword}%")
                  ->orWhere('hanviet', 'like', "%{$keyword}%")
                  ->orWhere('meaning', 'like', "%{$keyword}%");
            });
        }

        $kanjis = $query->paginate(24);

        return view('frontend.japanese.kanji', compact('kanjis', 'level'));
    }

    /**
     * Luyện thi JLPT trắc nghiệm tính giờ
     */
    public function jlpt(Request $request)
    {
        $level = $request->get('level', 'N5');
        $section = $request->get('section', 'all');

        $query = JapaneseJlptQuestion::query()->where('level', $level);
        if ($section !== 'all') {
            $query->where('section', $section);
        }

        $questions = $query->inRandomOrder()->limit(20)->get();

        return view('frontend.japanese.jlpt', compact('questions', 'level', 'section'));
    }

    /**
     * API nộp bài thi JLPT & chấm điểm
     */
    public function submitJlpt(Request $request)
    {
        $answers = $request->input('answers', []); // [question_id => user_option]
        $score = 0;
        $total = count($answers);
        $results = [];

        foreach ($answers as $qId => $selectedOption) {
            $question = JapaneseJlptQuestion::find($qId);
            if ($question) {
                $isCorrect = strtoupper($question->correct_option) === strtoupper($selectedOption);
                if ($isCorrect) {
                    $score++;
                }
                $results[] = [
                    'id' => $question->id,
                    'is_correct' => $isCorrect,
                    'correct_option' => $question->correct_option,
                    'explanation' => $question->explanation,
                ];
            }
        }

        return response()->json([
            'score' => $score,
            'total' => $total,
            'percentage' => $total > 0 ? round(($score / $total) * 100) : 0,
            'results' => $results,
        ]);
    }

    /**
     * API Ôn tập ngắt quãng SRS Flashcard (SM-2 Algorithm)
     */
    public function srsReview(Request $request)
    {
        $customerId = auth('customer')->id() ?? 1; // Fallback customer ID test
        $cardType = $request->input('card_type', 'vocabulary');
        $itemId = $request->input('item_id');
        $quality = (int) $request->input('quality', 4); // 0-5

        $card = JapaneseSrsCard::firstOrNew([
            'customer_id' => $customerId,
            'card_type' => $cardType,
            'item_id' => $itemId,
        ]);

        $card->review($quality);

        return response()->json([
            'message' => 'Review recorded',
            'interval_days' => $card->interval_days,
            'due_date' => $card->due_date->toIso8601String(),
        ]);
    }
}

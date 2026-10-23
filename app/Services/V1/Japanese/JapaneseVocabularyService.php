<?php

namespace App\Services\V1\Japanese;

use App\Repositories\Japanese\JapaneseVocabularyRepository;
use App\Models\JapaneseVocabulary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JapaneseVocabularyService
{
    protected $repository;

    public function __construct(JapaneseVocabularyRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(Request $request)
    {
        $query = JapaneseVocabulary::query()->with('lesson');

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('word', 'like', "%{$keyword}%")
                  ->orWhere('kanji', 'like', "%{$keyword}%")
                  ->orWhere('romaji', 'like', "%{$keyword}%")
                  ->orWhere('meaning', 'like', "%{$keyword}%");
            });
        }

        if ($lessonId = $request->input('lesson_id')) {
            if ($lessonId > 0) {
                $query->where('lesson_id', $lessonId);
            }
        }

        if ($level = $request->input('level')) {
            if ($level !== 'all') {
                $query->where('level', $level);
            }
        }

        $perPage = (int) $request->input('perpage', 20);
        return $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'lesson_id', 'word', 'kanji', 'romaji', 'meaning',
                'word_type', 'audio_url', 'example_sentence', 'example_meaning', 'level'
            ]);
            $vocab = $this->repository->create($payload);
            DB::commit();
            return $vocab;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function update(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'lesson_id', 'word', 'kanji', 'romaji', 'meaning',
                'word_type', 'audio_url', 'example_sentence', 'example_meaning', 'level'
            ]);
            $flag = $this->repository->update($id, $payload);
            DB::commit();
            return $flag;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $flag = $this->repository->delete($id);
            DB::commit();
            return $flag;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

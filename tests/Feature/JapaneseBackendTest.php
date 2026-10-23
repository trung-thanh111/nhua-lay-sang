<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\JapaneseLesson;
use App\Models\JapaneseVocabulary;
use App\Models\JapaneseGrammar;
use App\Models\JapaneseKanji;
use App\Models\JapaneseJlptQuestion;
use App\Models\JapaneseSrsCard;
use App\Services\V1\Japanese\JapaneseLessonService;
use App\Services\V1\Japanese\JapaneseVocabularyService;
use App\Services\V1\Japanese\JapaneseGrammarService;
use App\Services\V1\Japanese\JapaneseKanjiService;
use App\Services\V1\Japanese\JapaneseJlptService;
use Illuminate\Http\Request;

class JapaneseBackendTest extends TestCase
{
    /**
     * Test Lesson Service Filter & Pagination
     */
    public function test_lesson_service_filter(): void
    {
        $service = app(JapaneseLessonService::class);
        $request = new Request(['keyword' => 'Bài 1', 'level' => 'N5']);
        $results = $service->paginate($request);

        $this->assertGreaterThanOrEqual(1, $results->total());
        $this->assertEquals('N5', $results->first()->level);
    }

    /**
     * Test Vocabulary Service Filter
     */
    public function test_vocabulary_service_filter(): void
    {
        $service = app(JapaneseVocabularyService::class);
        $request = new Request(['keyword' => 'わたし']);
        $results = $service->paginate($request);

        $this->assertGreaterThanOrEqual(1, $results->total());
        $this->assertEquals('わたし', $results->first()->word);
    }

    /**
     * Test Grammar Service Filter
     */
    public function test_grammar_service_filter(): void
    {
        $service = app(JapaneseGrammarService::class);
        $request = new Request(['keyword' => 'です']);
        $results = $service->paginate($request);

        $this->assertGreaterThanOrEqual(1, $results->total());
    }

    /**
     * Test Kanji Service Filter
     */
    public function test_kanji_service_filter(): void
    {
        $service = app(JapaneseKanjiService::class);
        $request = new Request(['keyword' => 'NHẬT']);
        $results = $service->paginate($request);

        $this->assertGreaterThanOrEqual(1, $results->total());
        $this->assertEquals('日', $results->first()->character);
    }

    /**
     * Test JLPT Question Service Filter
     */
    public function test_jlpt_question_service_filter(): void
    {
        $service = app(JapaneseJlptService::class);
        $request = new Request(['level' => 'N5', 'section' => 'grammar']);
        $results = $service->paginate($request);

        $this->assertGreaterThanOrEqual(1, $results->total());
    }

    /**
     * Test SRS SM-2 Spaced Repetition calculation
     */
    public function test_srs_sm2_algorithm(): void
    {
        $card = new JapaneseSrsCard([
            'customer_id' => 999,
            'card_type' => 'vocabulary',
            'item_id' => 1,
        ]);

        $this->assertEquals(0, $card->repetitions);
        $this->assertEquals(1, $card->interval_days);

        // First review: Good (quality = 4)
        $card->review(4);
        $this->assertEquals(1, $card->repetitions);
        $this->assertEquals(1, $card->interval_days);

        // Second review: Good (quality = 4)
        $card->review(4);
        $this->assertEquals(2, $card->repetitions);
        $this->assertEquals(6, $card->interval_days);

        // Third review: Good (quality = 4)
        $card->review(4);
        $this->assertEquals(3, $card->repetitions);
        $this->assertGreaterThanOrEqual(15, $card->interval_days);
    }
}

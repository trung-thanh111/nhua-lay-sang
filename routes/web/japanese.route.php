<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\JapaneseController;
use App\Http\Controllers\Backend\V1\Japanese\LessonController as BackendLessonController;
use App\Http\Controllers\Backend\V1\Japanese\VocabularyController as BackendVocabularyController;
use App\Http\Controllers\Backend\V1\Japanese\GrammarController as BackendGrammarController;
use App\Http\Controllers\Backend\V1\Japanese\KanjiController as BackendKanjiController;
use App\Http\Controllers\Backend\V1\Japanese\JlptController as BackendJlptController;

/*
|--------------------------------------------------------------------------
| Frontend Routes (E-learning UI & API)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['locale'], 'prefix' => 'tieng-nhat'], function () {
    Route::get('/', [JapaneseController::class, 'index'])->name('japanese.index');
    Route::get('/bai-hoc/{code}', [JapaneseController::class, 'lesson'])->name('japanese.lesson');
    Route::get('/kanji', [JapaneseController::class, 'kanji'])->name('japanese.kanji');
    Route::get('/jlpt', [JapaneseController::class, 'jlpt'])->name('japanese.jlpt');
    Route::post('/jlpt/submit', [JapaneseController::class, 'submitJlpt'])->name('japanese.jlpt.submit');
    Route::post('/srs/review', [JapaneseController::class, 'srsReview'])->name('japanese.srs.review');
});

/*
|--------------------------------------------------------------------------
| Backend Admin Routes (CRUD, Filter & Data Management)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['admin', 'locale', 'backend_default_locale'], 'prefix' => 'japanese'], function () {
    // 1. Quản lý Bài học Minna
    Route::group(['prefix' => 'lesson'], function () {
        Route::get('index', [BackendLessonController::class, 'index'])->name('japanese.backend.lesson.index');
        Route::get('create', [BackendLessonController::class, 'create'])->name('japanese.backend.lesson.create');
        Route::post('store', [BackendLessonController::class, 'store'])->name('japanese.backend.lesson.store');
        Route::get('{id}/edit', [BackendLessonController::class, 'edit'])->where(['id' => '[0-9]+'])->name('japanese.backend.lesson.edit');
        Route::post('{id}/update', [BackendLessonController::class, 'update'])->where(['id' => '[0-9]+'])->name('japanese.backend.lesson.update');
        Route::get('{id}/delete', [BackendLessonController::class, 'delete'])->where(['id' => '[0-9]+'])->name('japanese.backend.lesson.delete');
        Route::delete('{id}/destroy', [BackendLessonController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('japanese.backend.lesson.destroy');
    });

    // 2. Quản lý Từ vựng
    Route::group(['prefix' => 'vocabulary'], function () {
        Route::get('index', [BackendVocabularyController::class, 'index'])->name('japanese.backend.vocabulary.index');
        Route::get('create', [BackendVocabularyController::class, 'create'])->name('japanese.backend.vocabulary.create');
        Route::post('store', [BackendVocabularyController::class, 'store'])->name('japanese.backend.vocabulary.store');
        Route::get('{id}/edit', [BackendVocabularyController::class, 'edit'])->where(['id' => '[0-9]+'])->name('japanese.backend.vocabulary.edit');
        Route::post('{id}/update', [BackendVocabularyController::class, 'update'])->where(['id' => '[0-9]+'])->name('japanese.backend.vocabulary.update');
        Route::get('{id}/delete', [BackendVocabularyController::class, 'delete'])->where(['id' => '[0-9]+'])->name('japanese.backend.vocabulary.delete');
        Route::delete('{id}/destroy', [BackendVocabularyController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('japanese.backend.vocabulary.destroy');
    });

    // 3. Quản lý Ngữ pháp
    Route::group(['prefix' => 'grammar'], function () {
        Route::get('index', [BackendGrammarController::class, 'index'])->name('japanese.backend.grammar.index');
        Route::get('create', [BackendGrammarController::class, 'create'])->name('japanese.backend.grammar.create');
        Route::post('store', [BackendGrammarController::class, 'store'])->name('japanese.backend.grammar.store');
        Route::get('{id}/edit', [BackendGrammarController::class, 'edit'])->where(['id' => '[0-9]+'])->name('japanese.backend.grammar.edit');
        Route::post('{id}/update', [BackendGrammarController::class, 'update'])->where(['id' => '[0-9]+'])->name('japanese.backend.grammar.update');
        Route::get('{id}/delete', [BackendGrammarController::class, 'delete'])->where(['id' => '[0-9]+'])->name('japanese.backend.grammar.delete');
        Route::delete('{id}/destroy', [BackendGrammarController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('japanese.backend.grammar.destroy');
    });

    // 4. Quản lý Chữ Hán (Kanji)
    Route::group(['prefix' => 'kanji'], function () {
        Route::get('index', [BackendKanjiController::class, 'index'])->name('japanese.backend.kanji.index');
        Route::get('create', [BackendKanjiController::class, 'create'])->name('japanese.backend.kanji.create');
        Route::post('store', [BackendKanjiController::class, 'store'])->name('japanese.backend.kanji.store');
        Route::get('{id}/edit', [BackendKanjiController::class, 'edit'])->where(['id' => '[0-9]+'])->name('japanese.backend.kanji.edit');
        Route::post('{id}/update', [BackendKanjiController::class, 'update'])->where(['id' => '[0-9]+'])->name('japanese.backend.kanji.update');
        Route::get('{id}/delete', [BackendKanjiController::class, 'delete'])->where(['id' => '[0-9]+'])->name('japanese.backend.kanji.delete');
        Route::delete('{id}/destroy', [BackendKanjiController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('japanese.backend.kanji.destroy');
    });

    // 5. Quản lý Đề thi JLPT
    Route::group(['prefix' => 'jlpt'], function () {
        Route::get('index', [BackendJlptController::class, 'index'])->name('japanese.backend.jlpt.index');
        Route::get('create', [BackendJlptController::class, 'create'])->name('japanese.backend.jlpt.create');
        Route::post('store', [BackendJlptController::class, 'store'])->name('japanese.backend.jlpt.store');
        Route::get('{id}/edit', [BackendJlptController::class, 'edit'])->where(['id' => '[0-9]+'])->name('japanese.backend.jlpt.edit');
        Route::post('{id}/update', [BackendJlptController::class, 'update'])->where(['id' => '[0-9]+'])->name('japanese.backend.jlpt.update');
        Route::get('{id}/delete', [BackendJlptController::class, 'delete'])->where(['id' => '[0-9]+'])->name('japanese.backend.jlpt.delete');
        Route::delete('{id}/destroy', [BackendJlptController::class, 'destroy'])->where(['id' => '[0-9]+'])->name('japanese.backend.jlpt.destroy');
    });
});

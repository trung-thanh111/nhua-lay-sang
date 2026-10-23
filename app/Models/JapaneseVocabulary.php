<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseVocabulary extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'word',
        'kanji',
        'romaji',
        'meaning',
        'word_type',
        'audio_url',
        'example_sentence',
        'example_meaning',
        'level',
    ];

    public function lesson()
    {
        return $this->belongsTo(JapaneseLesson::class, 'lesson_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'title',
        'category',
        'level',
        'lesson_number',
        'audio_url',
        'description',
        'kaiwa_content',
        'mondai_content',
        'publish',
    ];

    public function vocabularies()
    {
        return $this->hasMany(JapaneseVocabulary::class, 'lesson_id');
    }

    public function grammars()
    {
        return $this->hasMany(JapaneseGrammar::class, 'lesson_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseKanji extends Model
{
    use HasFactory;

    protected $fillable = [
        'character',
        'hanviet',
        'onyomi',
        'kunyomi',
        'strokes',
        'radical',
        'meaning',
        'stroke_svg',
        'compound_words',
        'level',
    ];

    protected $casts = [
        'compound_words' => 'array',
    ];
}

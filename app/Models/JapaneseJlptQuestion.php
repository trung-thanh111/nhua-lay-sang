<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseJlptQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'level',
        'section',
        'question',
        'audio_url',
        'option_a',
        'option_b',
        'option_c',
        'option_d',
        'correct_option',
        'explanation',
    ];
}

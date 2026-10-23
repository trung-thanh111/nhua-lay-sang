<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JapaneseGrammar extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'title',
        'structure',
        'meaning',
        'explanation',
        'examples',
        'level',
    ];

    protected $casts = [
        'examples' => 'array',
    ];

    public function lesson()
    {
        return $this->belongsTo(JapaneseLesson::class, 'lesson_id');
    }
}

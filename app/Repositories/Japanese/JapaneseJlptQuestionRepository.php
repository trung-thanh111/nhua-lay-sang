<?php

namespace App\Repositories\Japanese;

use App\Models\JapaneseJlptQuestion;
use App\Repositories\BaseRepository;

class JapaneseJlptQuestionRepository extends BaseRepository
{
    public function __construct(JapaneseJlptQuestion $model)
    {
        parent::__construct($model);
    }
}

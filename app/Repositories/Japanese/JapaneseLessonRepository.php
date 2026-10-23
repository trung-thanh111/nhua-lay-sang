<?php

namespace App\Repositories\Japanese;

use App\Models\JapaneseLesson;
use App\Repositories\BaseRepository;

class JapaneseLessonRepository extends BaseRepository
{
    public function __construct(JapaneseLesson $model)
    {
        parent::__construct($model);
    }
}

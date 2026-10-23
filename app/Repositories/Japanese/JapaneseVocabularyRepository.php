<?php

namespace App\Repositories\Japanese;

use App\Models\JapaneseVocabulary;
use App\Repositories\BaseRepository;

class JapaneseVocabularyRepository extends BaseRepository
{
    public function __construct(JapaneseVocabulary $model)
    {
        parent::__construct($model);
    }
}

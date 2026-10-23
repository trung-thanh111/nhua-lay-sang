<?php

namespace App\Repositories\Japanese;

use App\Models\JapaneseKanji;
use App\Repositories\BaseRepository;

class JapaneseKanjiRepository extends BaseRepository
{
    public function __construct(JapaneseKanji $model)
    {
        parent::__construct($model);
    }
}

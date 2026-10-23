<?php

namespace App\Repositories\Japanese;

use App\Models\JapaneseGrammar;
use App\Repositories\BaseRepository;

class JapaneseGrammarRepository extends BaseRepository
{
    public function __construct(JapaneseGrammar $model)
    {
        parent::__construct($model);
    }
}

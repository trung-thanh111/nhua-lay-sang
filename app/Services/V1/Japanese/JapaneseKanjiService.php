<?php

namespace App\Services\V1\Japanese;

use App\Repositories\Japanese\JapaneseKanjiRepository;
use App\Models\JapaneseKanji;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JapaneseKanjiService
{
    protected $repository;

    public function __construct(JapaneseKanjiRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(Request $request)
    {
        $query = JapaneseKanji::query();

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('character', 'like', "%{$keyword}%")
                  ->orWhere('hanviet', 'like', "%{$keyword}%")
                  ->orWhere('onyomi', 'like', "%{$keyword}%")
                  ->orWhere('kunyomi', 'like', "%{$keyword}%")
                  ->orWhere('meaning', 'like', "%{$keyword}%");
            });
        }

        if ($level = $request->input('level')) {
            if ($level !== 'all') {
                $query->where('level', $level);
            }
        }

        if ($strokes = $request->input('strokes')) {
            if ($strokes > 0) {
                $query->where('strokes', $strokes);
            }
        }

        $perPage = (int) $request->input('perpage', 24);
        return $query->orderBy('strokes', 'asc')->paginate($perPage)->withQueryString();
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'character', 'hanviet', 'onyomi', 'kunyomi',
                'strokes', 'radical', 'meaning', 'stroke_svg', 'level'
            ]);
            $compounds = $request->input('compound_words');
            if (is_string($compounds)) {
                $compounds = json_decode($compounds, true) ?: [];
            }
            $payload['compound_words'] = $compounds;

            $kanji = $this->repository->create($payload);
            DB::commit();
            return $kanji;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function update(int $id, Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'character', 'hanviet', 'onyomi', 'kunyomi',
                'strokes', 'radical', 'meaning', 'stroke_svg', 'level'
            ]);
            $compounds = $request->input('compound_words');
            if (is_string($compounds)) {
                $compounds = json_decode($compounds, true) ?: [];
            }
            $payload['compound_words'] = $compounds;

            $flag = $this->repository->update($id, $payload);
            DB::commit();
            return $flag;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }

    public function destroy(int $id)
    {
        DB::beginTransaction();
        try {
            $flag = $this->repository->delete($id);
            DB::commit();
            return $flag;
        } catch (\Exception $e) {
            DB::rollBack();
            return false;
        }
    }
}

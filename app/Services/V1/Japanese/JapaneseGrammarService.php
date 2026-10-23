<?php

namespace App\Services\V1\Japanese;

use App\Repositories\Japanese\JapaneseGrammarRepository;
use App\Models\JapaneseGrammar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JapaneseGrammarService
{
    protected $repository;

    public function __construct(JapaneseGrammarRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(Request $request)
    {
        $query = JapaneseGrammar::query()->with('lesson');

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('structure', 'like', "%{$keyword}%")
                  ->orWhere('meaning', 'like', "%{$keyword}%");
            });
        }

        if ($lessonId = $request->input('lesson_id')) {
            if ($lessonId > 0) {
                $query->where('lesson_id', $lessonId);
            }
        }

        if ($level = $request->input('level')) {
            if ($level !== 'all') {
                $query->where('level', $level);
            }
        }

        $perPage = (int) $request->input('perpage', 20);
        return $query->orderBy('id', 'desc')->paginate($perPage)->withQueryString();
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'lesson_id', 'title', 'structure', 'meaning',
                'explanation', 'level'
            ]);
            $examples = $request->input('examples');
            if (is_string($examples)) {
                $examples = json_decode($examples, true) ?: [];
            }
            $payload['examples'] = $examples;

            $grammar = $this->repository->create($payload);
            DB::commit();
            return $grammar;
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
                'lesson_id', 'title', 'structure', 'meaning',
                'explanation', 'level'
            ]);
            $examples = $request->input('examples');
            if (is_string($examples)) {
                $examples = json_decode($examples, true) ?: [];
            }
            $payload['examples'] = $examples;

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

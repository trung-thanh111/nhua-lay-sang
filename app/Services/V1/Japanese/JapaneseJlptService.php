<?php

namespace App\Services\V1\Japanese;

use App\Repositories\Japanese\JapaneseJlptQuestionRepository;
use App\Models\JapaneseJlptQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class JapaneseJlptService
{
    protected $repository;

    public function __construct(JapaneseJlptQuestionRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(Request $request)
    {
        $query = JapaneseJlptQuestion::query();

        if ($keyword = $request->input('keyword')) {
            $query->where('question', 'like', "%{$keyword}%")
                  ->orWhere('explanation', 'like', "%{$keyword}%");
        }

        if ($level = $request->input('level')) {
            if ($level !== 'all') {
                $query->where('level', $level);
            }
        }

        if ($section = $request->input('section')) {
            if ($section !== 'all') {
                $query->where('section', $section);
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
                'level', 'section', 'question', 'audio_url',
                'option_a', 'option_b', 'option_c', 'option_d',
                'correct_option', 'explanation'
            ]);
            $payload['correct_option'] = strtoupper($payload['correct_option']);

            $question = $this->repository->create($payload);
            DB::commit();
            return $question;
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
                'level', 'section', 'question', 'audio_url',
                'option_a', 'option_b', 'option_c', 'option_d',
                'correct_option', 'explanation'
            ]);
            $payload['correct_option'] = strtoupper($payload['correct_option']);

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

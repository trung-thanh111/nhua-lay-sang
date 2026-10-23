<?php

namespace App\Services\V1\Japanese;

use App\Repositories\Japanese\JapaneseLessonRepository;
use App\Models\JapaneseLesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class JapaneseLessonService
{
    protected $repository;

    public function __construct(JapaneseLessonRepository $repository)
    {
        $this->repository = $repository;
    }

    public function paginate(Request $request)
    {
        $query = JapaneseLesson::query();

        if ($keyword = $request->input('keyword')) {
            $query->where(function ($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%")
                  ->orWhere('code', 'like', "%{$keyword}%")
                  ->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        if ($level = $request->input('level')) {
            if ($level !== 'all') {
                $query->where('level', $level);
            }
        }

        if ($category = $request->input('category')) {
            if ($category !== 'all') {
                $query->where('category', $category);
            }
        }

        if ($publish = $request->input('publish')) {
            if ($publish > 0) {
                $query->where('publish', $publish);
            }
        }

        $perPage = (int) $request->input('perpage', 15);
        return $query->withCount(['vocabularies', 'grammars'])
            ->orderBy('lesson_number', 'asc')
            ->paginate($perPage)
            ->withQueryString();
    }

    public function create(Request $request)
    {
        DB::beginTransaction();
        try {
            $payload = $request->only([
                'title', 'category', 'level', 'lesson_number',
                'audio_url', 'description', 'kaiwa_content', 'mondai_content', 'publish'
            ]);
            $payload['code'] = $request->input('code') ?: Str::slug($payload['title']);
            $payload['publish'] = $payload['publish'] ?? 2;

            $lesson = $this->repository->create($payload);
            DB::commit();
            return $lesson;
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
                'code', 'title', 'category', 'level', 'lesson_number',
                'audio_url', 'description', 'kaiwa_content', 'mondai_content', 'publish'
            ]);
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

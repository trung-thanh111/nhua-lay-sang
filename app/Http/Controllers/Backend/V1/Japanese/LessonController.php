<?php

namespace App\Http\Controllers\Backend\V1\Japanese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\Japanese\JapaneseLessonService;
use App\Repositories\Japanese\JapaneseLessonRepository;

class LessonController extends Controller
{
    protected $service;
    protected $repository;

    public function __construct(
        JapaneseLessonService $service,
        JapaneseLessonRepository $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $lessons = $this->service->paginate($request);
        $config = [
            'seo' => ['title' => 'Quản lý Bài học Minna no Nihongo'],
            'model' => 'JapaneseLesson'
        ];
        $template = 'backend.japanese.lesson.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'lessons'));
    }

    public function create()
    {
        $config = [
            'seo' => ['title' => 'Thêm mới Bài học'],
            'method' => 'create'
        ];
        $template = 'backend.japanese.lesson.store';

        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'lesson_number' => 'required|integer|min:1',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->create($request)) {
            return redirect()->route('japanese.backend.lesson.index')->with('success', 'Thêm mới bài học thành công');
        }
        return redirect()->back()->with('error', 'Thêm mới thất bại. Vui lòng thử lại');
    }

    public function edit($id)
    {
        $lesson = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Cập nhật Bài học: ' . $lesson->title],
            'method' => 'edit'
        ];
        $template = 'backend.japanese.lesson.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'lesson'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'lesson_number' => 'required|integer|min:1',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->update($id, $request)) {
            return redirect()->route('japanese.backend.lesson.index')->with('success', 'Cập nhật bài học thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại');
    }

    public function delete($id)
    {
        $lesson = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Xác nhận xóa Bài học']
        ];
        $template = 'backend.japanese.lesson.delete';

        return view('backend.dashboard.layout', compact('template', 'config', 'lesson'));
    }

    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            return redirect()->route('japanese.backend.lesson.index')->with('success', 'Xóa bài học thành công');
        }
        return redirect()->route('japanese.backend.lesson.index')->with('error', 'Xóa bài học thất bại');
    }
}

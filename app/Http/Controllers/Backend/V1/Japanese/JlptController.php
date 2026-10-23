<?php

namespace App\Http\Controllers\Backend\V1\Japanese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\Japanese\JapaneseJlptService;
use App\Repositories\Japanese\JapaneseJlptQuestionRepository;

class JlptController extends Controller
{
    protected $service;
    protected $repository;

    public function __construct(
        JapaneseJlptService $service,
        JapaneseJlptQuestionRepository $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $questions = $this->service->paginate($request);
        $config = [
            'seo' => ['title' => 'Quản lý Đề thi JLPT'],
            'model' => 'JapaneseJlptQuestion'
        ];
        $template = 'backend.japanese.jlpt.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'questions'));
    }

    public function create()
    {
        $config = [
            'seo' => ['title' => 'Thêm mới Câu hỏi JLPT'],
            'method' => 'create'
        ];
        $template = 'backend.japanese.jlpt.store';

        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
            'section' => 'required|string|in:vocabulary,grammar,reading,listening',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_option' => 'required|string|in:A,B,C,D',
        ]);

        if ($this->service->create($request)) {
            return redirect()->route('japanese.backend.jlpt.index')->with('success', 'Thêm mới câu hỏi thành công');
        }
        return redirect()->back()->with('error', 'Thêm mới thất bại. Vui lòng thử lại');
    }

    public function edit($id)
    {
        $question = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Cập nhật Câu hỏi JLPT'],
            'method' => 'edit'
        ];
        $template = 'backend.japanese.jlpt.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'question'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
            'section' => 'required|string|in:vocabulary,grammar,reading,listening',
            'question' => 'required|string',
            'option_a' => 'required|string',
            'option_b' => 'required|string',
            'correct_option' => 'required|string|in:A,B,C,D',
        ]);

        if ($this->service->update($id, $request)) {
            return redirect()->route('japanese.backend.jlpt.index')->with('success', 'Cập nhật câu hỏi thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại');
    }

    public function delete($id)
    {
        $question = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Xác nhận xóa Câu hỏi']
        ];
        $template = 'backend.japanese.jlpt.delete';

        return view('backend.dashboard.layout', compact('template', 'config', 'question'));
    }

    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            return redirect()->route('japanese.backend.jlpt.index')->with('success', 'Xóa câu hỏi thành công');
        }
        return redirect()->route('japanese.backend.jlpt.index')->with('error', 'Xóa câu hỏi thất bại');
    }
}

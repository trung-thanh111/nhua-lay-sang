<?php

namespace App\Http\Controllers\Backend\V1\Japanese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\Japanese\JapaneseGrammarService;
use App\Repositories\Japanese\JapaneseGrammarRepository;
use App\Models\JapaneseLesson;

class GrammarController extends Controller
{
    protected $service;
    protected $repository;

    public function __construct(
        JapaneseGrammarService $service,
        JapaneseGrammarRepository $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $grammars = $this->service->paginate($request);
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Quản lý Ngữ pháp tiếng Nhật'],
            'model' => 'JapaneseGrammar'
        ];
        $template = 'backend.japanese.grammar.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'grammars', 'lessons'));
    }

    public function create()
    {
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Thêm mới Cấu trúc Ngữ pháp'],
            'method' => 'create'
        ];
        $template = 'backend.japanese.grammar.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'structure' => 'required|string|max:255',
            'meaning' => 'required|string',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->create($request)) {
            return redirect()->route('japanese.backend.grammar.index')->with('success', 'Thêm mới ngữ pháp thành công');
        }
        return redirect()->back()->with('error', 'Thêm mới thất bại. Vui lòng thử lại');
    }

    public function edit($id)
    {
        $grammar = $this->repository->findById($id);
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Cập nhật Ngữ pháp: ' . $grammar->title],
            'method' => 'edit'
        ];
        $template = 'backend.japanese.grammar.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'grammar', 'lessons'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'structure' => 'required|string|max:255',
            'meaning' => 'required|string',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->update($id, $request)) {
            return redirect()->route('japanese.backend.grammar.index')->with('success', 'Cập nhật ngữ pháp thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại');
    }

    public function delete($id)
    {
        $grammar = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Xác nhận xóa Ngữ pháp']
        ];
        $template = 'backend.japanese.grammar.delete';

        return view('backend.dashboard.layout', compact('template', 'config', 'grammar'));
    }

    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            return redirect()->route('japanese.backend.grammar.index')->with('success', 'Xóa ngữ pháp thành công');
        }
        return redirect()->route('japanese.backend.grammar.index')->with('error', 'Xóa ngữ pháp thất bại');
    }
}

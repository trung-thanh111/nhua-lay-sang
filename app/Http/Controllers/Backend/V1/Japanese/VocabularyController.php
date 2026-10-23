<?php

namespace App\Http\Controllers\Backend\V1\Japanese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\Japanese\JapaneseVocabularyService;
use App\Repositories\Japanese\JapaneseVocabularyRepository;
use App\Models\JapaneseLesson;

class VocabularyController extends Controller
{
    protected $service;
    protected $repository;

    public function __construct(
        JapaneseVocabularyService $service,
        JapaneseVocabularyRepository $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $vocabularies = $this->service->paginate($request);
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Quản lý Từ vựng tiếng Nhật'],
            'model' => 'JapaneseVocabulary'
        ];
        $template = 'backend.japanese.vocabulary.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'vocabularies', 'lessons'));
    }

    public function create()
    {
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Thêm mới Từ vựng'],
            'method' => 'create'
        ];
        $template = 'backend.japanese.vocabulary.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:100',
            'meaning' => 'required|string|max:255',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->create($request)) {
            return redirect()->route('japanese.backend.vocabulary.index')->with('success', 'Thêm mới từ vựng thành công');
        }
        return redirect()->back()->with('error', 'Thêm mới thất bại. Vui lòng thử lại');
    }

    public function edit($id)
    {
        $vocabulary = $this->repository->findById($id);
        $lessons = JapaneseLesson::orderBy('lesson_number', 'asc')->get();
        $config = [
            'seo' => ['title' => 'Cập nhật Từ vựng: ' . $vocabulary->word],
            'method' => 'edit'
        ];
        $template = 'backend.japanese.vocabulary.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'vocabulary', 'lessons'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'word' => 'required|string|max:100',
            'meaning' => 'required|string|max:255',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->update($id, $request)) {
            return redirect()->route('japanese.backend.vocabulary.index')->with('success', 'Cập nhật từ vựng thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại');
    }

    public function delete($id)
    {
        $vocabulary = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Xác nhận xóa Từ vựng']
        ];
        $template = 'backend.japanese.vocabulary.delete';

        return view('backend.dashboard.layout', compact('template', 'config', 'vocabulary'));
    }

    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            return redirect()->route('japanese.backend.vocabulary.index')->with('success', 'Xóa từ vựng thành công');
        }
        return redirect()->route('japanese.backend.vocabulary.index')->with('error', 'Xóa từ vựng thất bại');
    }
}

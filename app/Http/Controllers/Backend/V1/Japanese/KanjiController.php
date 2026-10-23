<?php

namespace App\Http\Controllers\Backend\V1\Japanese;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\V1\Japanese\JapaneseKanjiService;
use App\Repositories\Japanese\JapaneseKanjiRepository;

class KanjiController extends Controller
{
    protected $service;
    protected $repository;

    public function __construct(
        JapaneseKanjiService $service,
        JapaneseKanjiRepository $repository
    ) {
        $this->service = $service;
        $this->repository = $repository;
    }

    public function index(Request $request)
    {
        $kanjis = $this->service->paginate($request);
        $config = [
            'seo' => ['title' => 'Quản lý Hán tự (Kanji)'],
            'model' => 'JapaneseKanji'
        ];
        $template = 'backend.japanese.kanji.index';

        return view('backend.dashboard.layout', compact('template', 'config', 'kanjis'));
    }

    public function create()
    {
        $config = [
            'seo' => ['title' => 'Thêm mới Chữ Hán (Kanji)'],
            'method' => 'create'
        ];
        $template = 'backend.japanese.kanji.store';

        return view('backend.dashboard.layout', compact('template', 'config'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'character' => 'required|string|max:10|unique:japanese_kanjis,character',
            'hanviet' => 'required|string|max:100',
            'meaning' => 'required|string',
            'strokes' => 'required|integer|min:1',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->create($request)) {
            return redirect()->route('japanese.backend.kanji.index')->with('success', 'Thêm mới chữ Hán thành công');
        }
        return redirect()->back()->with('error', 'Thêm mới thất bại. Vui lòng thử lại');
    }

    public function edit($id)
    {
        $kanji = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Cập nhật Chữ Hán: ' . $kanji->character],
            'method' => 'edit'
        ];
        $template = 'backend.japanese.kanji.store';

        return view('backend.dashboard.layout', compact('template', 'config', 'kanji'));
    }

    public function update($id, Request $request)
    {
        $request->validate([
            'character' => 'required|string|max:10|unique:japanese_kanjis,character,' . $id,
            'hanviet' => 'required|string|max:100',
            'meaning' => 'required|string',
            'strokes' => 'required|integer|min:1',
            'level' => 'required|string|in:N5,N4,N3,N2,N1',
        ]);

        if ($this->service->update($id, $request)) {
            return redirect()->route('japanese.backend.kanji.index')->with('success', 'Cập nhật chữ Hán thành công');
        }
        return redirect()->back()->with('error', 'Cập nhật thất bại. Vui lòng thử lại');
    }

    public function delete($id)
    {
        $kanji = $this->repository->findById($id);
        $config = [
            'seo' => ['title' => 'Xác nhận xóa Chữ Hán']
        ];
        $template = 'backend.japanese.kanji.delete';

        return view('backend.dashboard.layout', compact('template', 'config', 'kanji'));
    }

    public function destroy($id)
    {
        if ($this->service->destroy($id)) {
            return redirect()->route('japanese.backend.kanji.index')->with('success', 'Xóa chữ Hán thành công');
        }
        return redirect()->route('japanese.backend.kanji.index')->with('error', 'Xóa chữ Hán thất bại');
    }
}

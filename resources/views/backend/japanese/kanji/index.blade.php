<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="active"><strong>Hán tự (Kanji)</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Chữ Hán (Kanji)</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('japanese.backend.kanji.create') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i> Thêm mới Chữ Hán
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="GET" class="form-inline m-b-md">
                        <div class="form-group m-r-sm">
                            <select name="level" class="form-control input-sm">
                                <option value="all">-- Cấp độ JLPT --</option>
                                @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                    <option value="{{ $lvl }}" {{ request('level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <input type="number" name="strokes" value="{{ request('strokes') }}" placeholder="Số nét..." class="form-control input-sm" style="width: 100px;">
                        </div>
                        <div class="form-group m-r-sm">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm chữ, Hán Việt, âm On/Kun..." class="form-control input-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lọc</button>
                        <a href="{{ route('japanese.backend.kanji.index') }}" class="btn btn-default btn-sm">Reset</a>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th class="text-center" style="width: 80px;">Chữ Hán</th>
                                    <th>Âm Hán Việt</th>
                                    <th>Onyomi</th>
                                    <th>Kunyomi</th>
                                    <th class="text-center">Số nét</th>
                                    <th>Ý nghĩa</th>
                                    <th class="text-center">Cấp độ</th>
                                    <th class="text-center" style="width: 120px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($kanjis as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $kanjis->firstItem() + $index }}</td>
                                        <td class="text-center"><strong style="font-size: 26px; font-family: 'Noto Sans JP', sans-serif;">{{ $item->character }}</strong></td>
                                        <td><span class="label label-danger font-bold uppercase">{{ $item->hanviet }}</span></td>
                                        <td><code>{{ $item->onyomi ?: '-' }}</code></td>
                                        <td><code>{{ $item->kunyomi ?: '-' }}</code></td>
                                        <td class="text-center">{{ $item->strokes }} nét</td>
                                        <td><span class="text-navy font-bold">{{ $item->meaning }}</span></td>
                                        <td class="text-center"><span class="label label-primary">{{ $item->level }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('japanese.backend.kanji.edit', $item->id) }}" class="btn btn-success btn-xs" title="Sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('japanese.backend.kanji.delete', $item->id) }}" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Không tìm thấy chữ Hán nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {{ $kanjis->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="active"><strong>Từ vựng tiếng Nhật</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Từ vựng</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('japanese.backend.vocabulary.create') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i> Thêm mới Từ vựng
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="GET" class="form-inline m-b-md">
                        <div class="form-group m-r-sm">
                            <select name="level" class="form-control input-sm">
                                <option value="all">-- Chọn cấp độ --</option>
                                @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                    <option value="{{ $lvl }}" {{ request('level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <select name="lesson_id" class="form-control input-sm">
                                <option value="0">-- Lọc theo bài học --</option>
                                @foreach($lessons as $l)
                                    <option value="{{ $l->id }}" {{ request('lesson_id') == $l->id ? 'selected' : '' }}>Bài {{ $l->lesson_number }}: {{ Str::limit($l->title, 30) }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm từ, kanji, nghĩa..." class="form-control input-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lọc</button>
                        <a href="{{ route('japanese.backend.vocabulary.index') }}" class="btn btn-default btn-sm">Reset</a>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th>Từ vựng (Kana)</th>
                                    <th>Chữ Hán (Kanji)</th>
                                    <th>Romaji</th>
                                    <th>Ý nghĩa tiếng Việt</th>
                                    <th>Thuộc bài</th>
                                    <th class="text-center">Cấp độ</th>
                                    <th class="text-center" style="width: 120px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($vocabularies as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $vocabularies->firstItem() + $index }}</td>
                                        <td><strong style="font-size: 16px;">{{ $item->word }}</strong></td>
                                        <td>{{ $item->kanji ?: '-' }}</td>
                                        <td><small class="text-muted">{{ $item->romaji }}</small></td>
                                        <td><span class="text-navy font-bold">{{ $item->meaning }}</span></td>
                                        <td>{{ $item->lesson ? 'Bài ' . $item->lesson->lesson_number . ' - ' . Str::limit($item->lesson->title, 20) : '-' }}</td>
                                        <td class="text-center"><span class="label label-primary">{{ $item->level }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('japanese.backend.vocabulary.edit', $item->id) }}" class="btn btn-success btn-xs" title="Sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('japanese.backend.vocabulary.delete', $item->id) }}" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center text-muted">Không có từ vựng nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {{ $vocabularies->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

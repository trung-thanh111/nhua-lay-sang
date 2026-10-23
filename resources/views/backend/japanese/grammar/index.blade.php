<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="active"><strong>Ngữ pháp tiếng Nhật</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Cấu trúc Ngữ pháp</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('japanese.backend.grammar.create') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i> Thêm mới Ngữ pháp
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
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm cấu trúc, tiêu đề..." class="form-control input-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lọc</button>
                        <a href="{{ route('japanese.backend.grammar.index') }}" class="btn btn-default btn-sm">Reset</a>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th>Tên mẫu câu</th>
                                    <th>Cấu trúc ngữ pháp</th>
                                    <th>Ý nghĩa</th>
                                    <th>Thuộc bài</th>
                                    <th class="text-center">Cấp độ</th>
                                    <th class="text-center" style="width: 120px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($grammars as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $grammars->firstItem() + $index }}</td>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td><code>{{ $item->structure }}</code></td>
                                        <td><span class="text-navy font-bold">{{ $item->meaning }}</span></td>
                                        <td>{{ $item->lesson ? 'Bài ' . $item->lesson->lesson_number : '-' }}</td>
                                        <td class="text-center"><span class="label label-primary">{{ $item->level }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('japanese.backend.grammar.edit', $item->id) }}" class="btn btn-success btn-xs" title="Sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('japanese.backend.grammar.delete', $item->id) }}" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Không có cấu trúc ngữ pháp nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {{ $grammars->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

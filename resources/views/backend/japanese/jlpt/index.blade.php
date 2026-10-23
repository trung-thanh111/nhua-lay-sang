<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="active"><strong>Ngân hàng câu hỏi JLPT</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Câu hỏi trắc nghiệm JLPT</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('japanese.backend.jlpt.create') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i> Thêm mới Câu hỏi
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <form action="" method="GET" class="form-inline m-b-md">
                        <div class="form-group m-r-sm">
                            <select name="level" class="form-control input-sm">
                                <option value="all">-- Cấp độ --</option>
                                @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                    <option value="{{ $lvl }}" {{ request('level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <select name="section" class="form-control input-sm">
                                <option value="all">-- Kỹ năng / Phần thi --</option>
                                <option value="vocabulary" {{ request('section') === 'vocabulary' ? 'selected' : '' }}>Từ vựng (Chữ Hán/Từ)</option>
                                <option value="grammar" {{ request('section') === 'grammar' ? 'selected' : '' }}>Ngữ pháp</option>
                                <option value="reading" {{ request('section') === 'reading' ? 'selected' : '' }}>Đọc hiểu</option>
                                <option value="listening" {{ request('section') === 'listening' ? 'selected' : '' }}>Nghe hiểu</option>
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm trong nội dung câu hỏi..." class="form-control input-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lọc</button>
                        <a href="{{ route('japanese.backend.jlpt.index') }}" class="btn btn-default btn-sm">Reset</a>
                    </form>

                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th>Nội dung câu hỏi</th>
                                    <th>Các lựa chọn</th>
                                    <th class="text-center">Đáp án đúng</th>
                                    <th class="text-center">Phần thi</th>
                                    <th class="text-center">Cấp độ</th>
                                    <th class="text-center" style="width: 120px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($questions as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $questions->firstItem() + $index }}</td>
                                        <td><strong>{{ $item->question }}</strong></td>
                                        <td>
                                            <small>
                                                <strong>A:</strong> {{ $item->option_a }} | 
                                                <strong>B:</strong> {{ $item->option_b }} | 
                                                <strong>C:</strong> {{ $item->option_c }} 
                                                @if($item->option_d) | <strong>D:</strong> {{ $item->option_d }} @endif
                                            </small>
                                        </td>
                                        <td class="text-center"><span class="badge badge-success font-bold">{{ $item->correct_option }}</span></td>
                                        <td class="text-center"><span class="label label-info uppercase">{{ $item->section }}</span></td>
                                        <td class="text-center"><span class="label label-primary">{{ $item->level }}</span></td>
                                        <td class="text-center">
                                            <a href="{{ route('japanese.backend.jlpt.edit', $item->id) }}" class="btn btn-success btn-xs" title="Sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('japanese.backend.jlpt.delete', $item->id) }}" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center text-muted">Không có câu hỏi nào.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {{ $questions->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

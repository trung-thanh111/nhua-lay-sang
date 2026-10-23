<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb" style="margin-bottom: 10px;">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li class="active"><strong>Bài học Minna no Nihongo</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Danh sách Bài học</h5>
                    <div class="ibox-tools">
                        <a href="{{ route('japanese.backend.lesson.create') }}" class="btn btn-danger btn-sm">
                            <i class="fa fa-plus"></i> Thêm mới Bài học
                        </a>
                    </div>
                </div>
                <div class="ibox-content">
                    <!-- Filter form -->
                    <form action="" method="GET" class="form-inline m-b-md">
                        <div class="form-group m-r-sm">
                            <select name="level" class="form-control input-sm">
                                <option value="all">-- Chọn cấp độ (Level) --</option>
                                @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                    <option value="{{ $lvl }}" {{ request('level') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <select name="category" class="form-control input-sm">
                                <option value="all">-- Thể loại --</option>
                                <option value="minna" {{ request('category') === 'minna' ? 'selected' : '' }}>Minna no Nihongo</option>
                                <option value="jlpt" {{ request('category') === 'jlpt' ? 'selected' : '' }}>Luyện thi JLPT</option>
                                <option value="conversation" {{ request('category') === 'conversation' ? 'selected' : '' }}>Giao tiếp</option>
                            </select>
                        </div>
                        <div class="form-group m-r-sm">
                            <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Tìm theo tên hoặc mã..." class="form-control input-sm">
                        </div>
                        <button type="submit" class="btn btn-primary btn-sm"><i class="fa fa-search"></i> Lọc</button>
                        <a href="{{ route('japanese.backend.lesson.index') }}" class="btn btn-default btn-sm">Reset</a>
                    </form>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 50px;">STT</th>
                                    <th>Mã bài</th>
                                    <th>Tiêu đề bài học</th>
                                    <th class="text-center">Số bài</th>
                                    <th class="text-center">Cấp độ</th>
                                    <th class="text-center">Số từ vựng</th>
                                    <th class="text-center">Số ngữ pháp</th>
                                    <th class="text-center">Trạng thái</th>
                                    <th class="text-center" style="width: 120px;">Hành động</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($lessons as $index => $item)
                                    <tr>
                                        <td class="text-center">{{ $lessons->firstItem() + $index }}</td>
                                        <td><code>{{ $item->code }}</code></td>
                                        <td><strong>{{ $item->title }}</strong></td>
                                        <td class="text-center">Bài {{ $item->lesson_number }}</td>
                                        <td class="text-center"><span class="label label-primary">{{ $item->level }}</span></td>
                                        <td class="text-center"><span class="badge badge-info">{{ $item->vocabularies_count }}</span></td>
                                        <td class="text-center"><span class="badge badge-success">{{ $item->grammars_count }}</span></td>
                                        <td class="text-center">
                                            @if($item->publish == 2)
                                                <span class="label label-primary">Hiển thị</span>
                                            @else
                                                <span class="label label-default">Bản nháp</span>
                                            @endif
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('japanese.backend.lesson.edit', $item->id) }}" class="btn btn-success btn-xs" title="Sửa"><i class="fa fa-edit"></i></a>
                                            <a href="{{ route('japanese.backend.lesson.delete', $item->id) }}" class="btn btn-danger btn-xs" title="Xóa"><i class="fa fa-trash"></i></a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="9" class="text-center text-muted">Không có dữ liệu phù hợp.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="text-right">
                        {{ $lessons->links('pagination::bootstrap-4') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

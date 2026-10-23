<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.grammar.index') }}">Ngữ pháp</a></li>
            <li class="active"><strong>{{ $config['method'] === 'create' ? 'Thêm mới' : 'Cập nhật' }}</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin cấu trúc ngữ pháp</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ $config['method'] === 'create' ? route('japanese.backend.grammar.store') : route('japanese.backend.grammar.update', $grammar->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Thuộc bài học</label>
                            <div class="col-sm-4">
                                <select name="lesson_id" class="form-control">
                                    <option value="">-- Chọn bài học --</option>
                                    @foreach($lessons as $l)
                                        <option value="{{ $l->id }}" {{ old('lesson_id', $grammar->lesson_id ?? '') == $l->id ? 'selected' : '' }}>Bài {{ $l->lesson_number }}: {{ $l->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Cấp độ (Level) <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="level" class="form-control" required>
                                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $grammar->level ?? 'N5') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tên mẫu câu <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="{{ old('title', $grammar->title ?? '') }}" class="form-control" required placeholder="Ví dụ: Khẳng định: N1 は N2 です">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cấu trúc công thức <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="structure" value="{{ old('structure', $grammar->structure ?? '') }}" class="form-control" required placeholder="Ví dụ: N1 [Danh từ 1] + は + N2 [Danh từ 2] + です">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ý nghĩa <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="meaning" value="{{ old('meaning', $grammar->meaning ?? '') }}" class="form-control" required placeholder="Ví dụ: N1 là N2">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Giải thích chi tiết</label>
                            <div class="col-sm-10">
                                <textarea name="explanation" rows="4" class="form-control" placeholder="Giải thích cách dùng, trợ từ, lưu ý...">{{ old('explanation', $grammar->explanation ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Ví dụ (JSON / Text)</label>
                            <div class="col-sm-10">
                                <textarea name="examples" rows="4" class="form-control" placeholder='[{"ja":"わたしはマイクです。","vi":"Tôi là Mike."}]'>{{ old('examples', isset($grammar->examples) ? json_encode($grammar->examples, JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                                <span class="help-block m-b-none text-muted">Định dạng JSON mảng ví dụ: <code>[{"ja":"câu tiếng Nhật", "vi":"nghĩa tiếng Việt"}]</code></span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu ngữ pháp</button>
                                <a href="{{ route('japanese.backend.grammar.index') }}" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

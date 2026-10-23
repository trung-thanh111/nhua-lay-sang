<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.jlpt.index') }}">Câu hỏi JLPT</a></li>
            <li class="active"><strong>{{ $config['method'] === 'create' ? 'Thêm mới' : 'Cập nhật' }}</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Nội dung câu hỏi trắc nghiệm</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ $config['method'] === 'create' ? route('japanese.backend.jlpt.store') : route('japanese.backend.jlpt.update', $question->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cấp độ (Level) <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="level" class="form-control" required>
                                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $question->level ?? 'N5') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Phần thi / Kỹ năng <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="section" class="form-control" required>
                                    <option value="vocabulary" {{ old('section', $question->section ?? '') === 'vocabulary' ? 'selected' : '' }}>Từ vựng (Chữ Hán / Từ ngữ)</option>
                                    <option value="grammar" {{ old('section', $question->section ?? '') === 'grammar' ? 'selected' : '' }}>Ngữ pháp</option>
                                    <option value="reading" {{ old('section', $question->section ?? '') === 'reading' ? 'selected' : '' }}>Đọc hiểu</option>
                                    <option value="listening" {{ old('section', $question->section ?? '') === 'listening' ? 'selected' : '' }}>Nghe hiểu</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Câu hỏi <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <textarea name="question" rows="3" class="form-control" required placeholder="Nhập nội dung câu hỏi...">{{ old('question', $question->question ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lựa chọn A <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="option_a" value="{{ old('option_a', $question->option_a ?? '') }}" class="form-control" required>
                            </div>
                            <label class="col-sm-2 control-label">Lựa chọn B <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="option_b" value="{{ old('option_b', $question->option_b ?? '') }}" class="form-control" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Lựa chọn C <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="option_c" value="{{ old('option_c', $question->option_c ?? '') }}" class="form-control" required>
                            </div>
                            <label class="col-sm-2 control-label">Lựa chọn D</label>
                            <div class="col-sm-4">
                                <input type="text" name="option_d" value="{{ old('option_d', $question->option_d ?? '') }}" class="form-control">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Đáp án đúng <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="correct_option" class="form-control" required>
                                    @foreach(['A', 'B', 'C', 'D'] as $opt)
                                        <option value="{{ $opt }}" {{ old('correct_option', $question->correct_option ?? 'A') === $opt ? 'selected' : '' }}>Lựa chọn {{ $opt }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Audio URL (Nghe)</label>
                            <div class="col-sm-4">
                                <input type="text" name="audio_url" value="{{ old('audio_url', $question->audio_url ?? '') }}" class="form-control" placeholder="Link audio nếu là bài thi nghe">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Giải thích chi tiết</label>
                            <div class="col-sm-10">
                                <textarea name="explanation" rows="3" class="form-control" placeholder="Giải thích tại sao chọn đáp án này...">{{ old('explanation', $question->explanation ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu câu hỏi</button>
                                <a href="{{ route('japanese.backend.jlpt.index') }}" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

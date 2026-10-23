<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.lesson.index') }}">Bài học</a></li>
            <li class="active"><strong>{{ $config['method'] === 'create' ? 'Thêm mới' : 'Cập nhật' }}</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin bài học</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ $config['method'] === 'create' ? route('japanese.backend.lesson.store') : route('japanese.backend.lesson.update', $lesson->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Tiêu đề bài học <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="title" value="{{ old('title', $lesson->title ?? '') }}" class="form-control" required placeholder="Ví dụ: Bài 1: Giới thiệu bản thân (自己紹介)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mã định danh (Code)</label>
                            <div class="col-sm-4">
                                <input type="text" name="code" value="{{ old('code', $lesson->code ?? '') }}" class="form-control" placeholder="Để trống tự động tạo slug (minna-bai-01)">
                            </div>
                            <label class="col-sm-2 control-label">Số thứ tự bài <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="lesson_number" value="{{ old('lesson_number', $lesson->lesson_number ?? 1) }}" class="form-control" min="1" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Cấp độ (Level) <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="level" class="form-control" required>
                                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $lesson->level ?? '') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Thể loại</label>
                            <div class="col-sm-4">
                                <select name="category" class="form-control">
                                    <option value="minna" {{ old('category', $lesson->category ?? '') === 'minna' ? 'selected' : '' }}>Minna no Nihongo</option>
                                    <option value="jlpt" {{ old('category', $lesson->category ?? '') === 'jlpt' ? 'selected' : '' }}>Luyện thi JLPT</option>
                                    <option value="conversation" {{ old('category', $lesson->category ?? '') === 'conversation' ? 'selected' : '' }}>Hội thoại giao tiếp</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Audio URL</label>
                            <div class="col-sm-10">
                                <input type="text" name="audio_url" value="{{ old('audio_url', $lesson->audio_url ?? '') }}" class="form-control" placeholder="Đường link file MP3 bài nghe">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Mô tả tóm tắt</label>
                            <div class="col-sm-10">
                                <textarea name="description" rows="3" class="form-control" placeholder="Mục tiêu của bài học...">{{ old('description', $lesson->description ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nội dung Hội thoại (Kaiwa)</label>
                            <div class="col-sm-10">
                                <textarea name="kaiwa_content" rows="6" class="form-control" placeholder="Đoạn hội thoại mẫu...">{{ old('kaiwa_content', $lesson->kaiwa_content ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Trạng thái</label>
                            <div class="col-sm-4">
                                <select name="publish" class="form-control">
                                    <option value="2" {{ old('publish', $lesson->publish ?? 2) == 2 ? 'selected' : '' }}>Hiển thị (Publish)</option>
                                    <option value="1" {{ old('publish', $lesson->publish ?? 2) == 1 ? 'selected' : '' }}>Bản nháp (Draft)</option>
                                </select>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu thông tin</button>
                                <a href="{{ route('japanese.backend.lesson.index') }}" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

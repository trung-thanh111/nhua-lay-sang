<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.vocabulary.index') }}">Từ vựng</a></li>
            <li class="active"><strong>{{ $config['method'] === 'create' ? 'Thêm mới' : 'Cập nhật' }}</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin từ vựng</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ $config['method'] === 'create' ? route('japanese.backend.vocabulary.store') : route('japanese.backend.vocabulary.update', $vocabulary->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Thuộc bài học</label>
                            <div class="col-sm-4">
                                <select name="lesson_id" class="form-control">
                                    <option value="">-- Chọn bài học --</option>
                                    @foreach($lessons as $l)
                                        <option value="{{ $l->id }}" {{ old('lesson_id', $vocabulary->lesson_id ?? '') == $l->id ? 'selected' : '' }}>Bài {{ $l->lesson_number }}: {{ $l->title }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <label class="col-sm-2 control-label">Cấp độ (Level) <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="level" class="form-control" required>
                                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $vocabulary->level ?? 'N5') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Từ vựng (Kana) <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="word" value="{{ old('word', $vocabulary->word ?? '') }}" class="form-control" required placeholder="わたし, がくせい...">
                            </div>
                            <label class="col-sm-2 control-label">Chữ Hán (Kanji)</label>
                            <div class="col-sm-4">
                                <input type="text" name="kanji" value="{{ old('kanji', $vocabulary->kanji ?? '') }}" class="form-control" placeholder="私, 学生...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phiên âm Romaji</label>
                            <div class="col-sm-4">
                                <input type="text" name="romaji" value="{{ old('romaji', $vocabulary->romaji ?? '') }}" class="form-control" placeholder="watashi, gakusei...">
                            </div>
                            <label class="col-sm-2 control-label">Từ loại</label>
                            <div class="col-sm-4">
                                <input type="text" name="word_type" value="{{ old('word_type', $vocabulary->word_type ?? '') }}" class="form-control" placeholder="Danh từ, Động từ nhóm 1...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Nghĩa tiếng Việt <span class="text-danger">*</span></label>
                            <div class="col-sm-10">
                                <input type="text" name="meaning" value="{{ old('meaning', $vocabulary->meaning ?? '') }}" class="form-control" required placeholder="Tôi, học sinh...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Audio URL</label>
                            <div class="col-sm-10">
                                <input type="text" name="audio_url" value="{{ old('audio_url', $vocabulary->audio_url ?? '') }}" class="form-control" placeholder="Link audio phát âm (tùy chọn)">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Câu ví dụ</label>
                            <div class="col-sm-10">
                                <input type="text" name="example_sentence" value="{{ old('example_sentence', $vocabulary->example_sentence ?? '') }}" class="form-control" placeholder="わたしはベトナムじんです。">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Dịch câu ví dụ</label>
                            <div class="col-sm-10">
                                <input type="text" name="example_meaning" value="{{ old('example_meaning', $vocabulary->example_meaning ?? '') }}" class="form-control" placeholder="Tôi là người Việt Nam.">
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu từ vựng</button>
                                <a href="{{ route('japanese.backend.vocabulary.index') }}" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

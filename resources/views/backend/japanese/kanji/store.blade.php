<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.kanji.index') }}">Chữ Hán</a></li>
            <li class="active"><strong>{{ $config['method'] === 'create' ? 'Thêm mới' : 'Cập nhật' }}</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-12">
            <div class="ibox float-e-margins">
                <div class="ibox-title">
                    <h5>Thông tin Chữ Hán (Kanji)</h5>
                </div>
                <div class="ibox-content">
                    <form action="{{ $config['method'] === 'create' ? route('japanese.backend.kanji.store') : route('japanese.backend.kanji.update', $kanji->id) }}" method="POST" class="form-horizontal">
                        @csrf
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Chữ Hán <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="character" value="{{ old('character', $kanji->character ?? '') }}" class="form-control" required placeholder="日, 本, 人..." style="font-size: 20px;">
                            </div>
                            <label class="col-sm-2 control-label">Âm Hán Việt <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="hanviet" value="{{ old('hanviet', $kanji->hanviet ?? '') }}" class="form-control" required placeholder="NHẬT, BẢN, NHÂN...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Âm Onyomi</label>
                            <div class="col-sm-4">
                                <input type="text" name="onyomi" value="{{ old('onyomi', $kanji->onyomi ?? '') }}" class="form-control" placeholder="NICHI, JITSU...">
                            </div>
                            <label class="col-sm-2 control-label">Âm Kunyomi</label>
                            <div class="col-sm-4">
                                <input type="text" name="kunyomi" value="{{ old('kunyomi', $kanji->kunyomi ?? '') }}" class="form-control" placeholder="hi, bi, ka...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Số nét <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="number" name="strokes" value="{{ old('strokes', $kanji->strokes ?? 1) }}" class="form-control" min="1" required>
                            </div>
                            <label class="col-sm-2 control-label">Cấp độ JLPT <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <select name="level" class="form-control" required>
                                    @foreach(['N5', 'N4', 'N3', 'N2', 'N1'] as $lvl)
                                        <option value="{{ $lvl }}" {{ old('level', $kanji->level ?? 'N5') === $lvl ? 'selected' : '' }}>{{ $lvl }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Bộ thủ (Radical)</label>
                            <div class="col-sm-4">
                                <input type="text" name="radical" value="{{ old('radical', $kanji->radical ?? '') }}" class="form-control" placeholder="日 (Nhật), 木 (Mộc)...">
                            </div>
                            <label class="col-sm-2 control-label">Ý nghĩa <span class="text-danger">*</span></label>
                            <div class="col-sm-4">
                                <input type="text" name="meaning" value="{{ old('meaning', $kanji->meaning ?? '') }}" class="form-control" required placeholder="Mặt trời, ngày...">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">SVG Thứ tự nét viết</label>
                            <div class="col-sm-10">
                                <textarea name="stroke_svg" rows="3" class="form-control" placeholder="Dữ liệu SVG vẽ nét (KanjiVG)...">{{ old('stroke_svg', $kanji->stroke_svg ?? '') }}</textarea>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Từ ghép liên quan (JSON)</label>
                            <div class="col-sm-10">
                                <textarea name="compound_words" rows="4" class="form-control" placeholder='[{"word":"日本","meaning":"Nhật Bản"}]'>{{ old('compound_words', isset($kanji->compound_words) ? json_encode($kanji->compound_words, JSON_UNESCAPED_UNICODE) : '') }}</textarea>
                                <span class="help-block m-b-none text-muted">Định dạng JSON: <code>[{"word":"Từ ghép", "meaning":"Nghĩa"}]</code></span>
                            </div>
                        </div>

                        <div class="hr-line-dashed"></div>

                        <div class="form-group">
                            <div class="col-sm-4 col-sm-offset-2">
                                <button class="btn btn-primary" type="submit"><i class="fa fa-save"></i> Lưu chữ Hán</button>
                                <a href="{{ route('japanese.backend.kanji.index') }}" class="btn btn-default">Hủy</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

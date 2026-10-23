<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2>{{ $config['seo']['title'] }}</h2>
        <ol class="breadcrumb">
            <li><a href="{{ route('dashboard.index') }}">Dashboard</a></li>
            <li><a href="{{ route('japanese.backend.jlpt.index') }}">Câu hỏi JLPT</a></li>
            <li class="active"><strong>Xóa câu hỏi</strong></li>
        </ol>
    </div>
</div>

<div class="wrapper wrapper-content animated fadeInRight">
    <div class="row">
        <div class="col-lg-6 col-lg-offset-3">
            <div class="ibox float-e-margins border-danger">
                <div class="ibox-title bg-danger">
                    <h5><i class="fa fa-warning"></i> Cảnh báo xóa</h5>
                </div>
                <div class="ibox-content text-center p-md">
                    <h3 class="text-danger m-b-md">Bạn có chắc chắn muốn xóa câu hỏi này?</h3>
                    <p class="text-muted">
                        Câu hỏi: <strong>{{ $question->question }}</strong>
                        <br>Cấp độ: <code>{{ $question->level }}</code> - Phần: <code>{{ $question->section }}</code>
                    </p>

                    <form action="{{ route('japanese.backend.jlpt.destroy', $question->id) }}" method="POST" class="m-t-md">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-lg"><i class="fa fa-trash"></i> Xác nhận Xóa</button>
                        <a href="{{ route('japanese.backend.jlpt.index') }}" class="btn btn-default btn-lg">Hủy bỏ</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

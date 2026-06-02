@extends('frontend.homepage.layout')

@section('content')
<div class="breadcrumb">
    <div class="uk-container uk-container-center">
        <ul class="uk-breadcrumb">
            <li><a href="{{ url('/') }}" title="Trang chủ">Trang chủ</a></li>
            <li class="uk-active"><a href="{{ route('contact.index') }}" title="Liên hệ">Liên hệ</a></li>
        </ul>
    </div>
</div>
<section class="main-content">
    <div class="uk-container uk-container-center">
        <section class="uk-panel contact">
            <section class="panel-body">
                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-3-4">
                        <div class="contact-infomation">
                            <div class="note">Cám ơn quý khách đã ghé thăm website chúng tôi.</div>
                            <h2 class="company">{{ $system['homepage_brandname'] ?? $system['homepage_company'] ?? '' }}</h2>
                            <div class="address">
                                {!! $system['contact_contact'] ?? '' !!}
                            </div>
                            <div class="contact-map">
                                {!! $system['contact_map'] ?? '' !!}
                            </div>
                        </div>
                    </div>
                    <div class="uk-width-large-1-4">
                        <div class="contact-form">
                            <div class="label">Mời bạn điền vào mẫu thư liên lạc và gửi đi cho chúng tôi. Các chuyên viên tư vấn của chúng tôi sẽ trả lời bạn trong thời gian sớm nhất.</div>

                            @if(session('success'))
                                <div class="uk-alert uk-alert-success">{{ session('success') }}</div>
                            @endif
                            @if(session('error'))
                                <div class="uk-alert uk-alert-danger">{{ session('error') }}</div>
                            @endif

                            <form action="{{ route('contact.save') }}" method="post" class="uk-form form">
                                @csrf
                                @if ($errors->any())
                                    <div class="callout callout-danger" style="padding:10px;background:rgb(195,94,94);color:#fff;margin-bottom:10px;">
                                        @foreach ($errors->all() as $error)
                                            <div>{{ $error }}</div>
                                        @endforeach
                                    </div>
                                @endif
                                <div class="uk-grid lib-grid-20 uk-grid-width-small-1-2 uk-grid-width-large-1-1">
                                    <div class="form-row">
                                        <input type="text" name="name" value="{{ old('name') }}" class="uk-width-1-1 input-text" placeholder="Họ &amp; tên *">
                                    </div>
                                    <div class="form-row">
                                        <input type="text" name="email" value="{{ old('email') }}" class="uk-width-1-1 input-text" placeholder="Email *">
                                    </div>
                                    <div class="form-row">
                                        <input type="text" name="phone" value="{{ old('phone') }}" class="uk-width-1-1 input-text" placeholder="Số điện thoại">
                                    </div>
                                    <div class="form-row">
                                        <input type="text" name="address" value="{{ old('address') }}" class="uk-width-1-1 input-text" placeholder="Địa chỉ">
                                    </div>
                                    <div class="form-row">
                                        <input type="text" name="title" value="{{ old('title') }}" class="uk-width-1-1 input-text" placeholder="Tiêu đề thư *">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <textarea name="message" class="uk-width-1-1 form-textarea" placeholder="Nội dung *">{{ old('message') }}</textarea>
                                </div>
                                <div class="form-row uk-text-right">
                                    <input type="submit" name="create" class="btn-submit" value="Gửi đi">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </section>
        </section>
    </div>
</section>
@endsection

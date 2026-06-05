@php
    $footerMenu = navigations_array('footer', $config['language'] ?? 1);
    $partner = \App\Support\LegacyFrontend::slides(['partner'], $config['language'] ?? 1)['partner']['item'] ?? [];
@endphp
<section class="footer-commitment uk-visible-large">
    <div class="uk-container uk-container-center">
        <div class="uk-grid lib-grid-15 uk-grid-width-small-1-2 uk-grid-width-large-1-4">
            @php
                $commitments = \Illuminate\Support\Facades\Cache::remember('footer_commitments_lang_' . ($config['language'] ?? 1), 3600, function() use ($config) {
                    $langId = $config['language'] ?? 1;
                    $publishCol = \Illuminate\Support\Facades\Schema::hasColumn('posts', 'publish') ? 'publish' : 'pubish';
                    $posts = \Illuminate\Support\Facades\DB::table('posts')
                        ->join('post_language', 'post_language.post_id', '=', 'posts.id')
                        ->whereIn('posts.id', [2, 3, 4, 5])
                        ->where('post_language.language_id', $langId)
                        ->where("posts.{$publishCol}", 2)
                        ->whereNull('posts.deleted_at')
                        ->select('post_language.name as title', 'post_language.description as subtitle')
                        ->orderByRaw('FIELD(posts.id, 5, 4, 3, 2)')
                        ->get();

                    if ($posts->count() < 4) {
                        return [
                            ['title' => 'DỊCH VỤ CHUYÊN NGHIỆP', 'subtitle' => 'Chuyên nghiệp - Tận tâm - Linh hoạt'],
                            ['title' => 'SẢN PHẨM ĐA DẠNG', 'subtitle' => 'Đa dạng về mục đích sử dụng'],
                            ['title' => 'UY TÍN HÀNG ĐẦU', 'subtitle' => 'Năng lực & Nhiệt huyết'],
                            ['title' => 'MẪU MÃ ĐA DẠNG', 'subtitle' => 'Sản phẩm chất lượng cao'],
                        ];
                    }

                    return $posts->map(function($post) {
                        return [
                            'title' => mb_strtoupper($post->title, 'UTF-8'),
                            'subtitle' => trim(strip_tags(html_entity_decode($post->subtitle)))
                        ];
                    })->all();
                });
            @endphp
            @foreach($commitments as $item)
                <div class="commitment-item">
                    <div class="content uk-flex uk-flex-middle">
                        <div class="text">
                            <div class="title">{{ $item['title'] }}</div>
                            <div class="subtitle">{{ $item['subtitle'] }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- <section class="footer-commitment uk-visible-large">
    <div class="uk-container uk-container-center">
        <div class="uk-grid lib-grid-15 uk-grid-width-small-1-2 uk-grid-width-large-1-4">
            @foreach(array_slice($highlight_post ?? [], 0, 4) as $item)
                <div class="commitment-item">
                    <div class="content uk-flex uk-flex-middle">
                        <div class="text">
                            <div class="title">{{ $item['title'] ?? '' }}</div>
                            <div class="subtitle">{{ strip_tags($item['description'] ?? '') }}</div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section> --}}

<footer class="footer" id="footer">
    <div class="uk-container uk-container-center">
        @if(count($partner))
            <section class="middle">
                <div class="uk-slidenav-position slider-partner slide_arrow1" data-uk-slider="{autoplay:true, autoplayInterval:4500}">
                    <div class="uk-slider-container">
                        <ul class="uk-slider uk-grid ec-grid-5 uk-grid-width-1-2 uk-grid-width-small-1-3 uk-grid-width-medium-1-4 uk-grid-width-large-1-6 uk-flex-middle">
                            @foreach($partner as $item)
                                <li class="item"><a class="image img-scaledown" href="{{ $item['url'] ?? '#' }}" title="{{ $item['name'] ?? '' }}"><img class="lazy" data-original="{{ $item['image'] ?? '' }}" src="{{ $item['image'] ?? '' }}" alt="{{ $item['alt'] ?? $item['name'] ?? '' }}"></a></li>
                            @endforeach
                        </ul>
                        <a href="" class="uk-slidenav uk-slidenav-previous" data-uk-slider-item="previous"></a>
                        <a href="" class="uk-slidenav uk-slidenav-next" data-uk-slider-item="next"></a>
                    </div>
                </div>
            </section>
        @endif
        <section class="top">
            <div class="uk-grid lib-grid-20">
                @foreach($footerMenu as $menu)
                    <div class="uk-width-small-1-2 uk-width-medium-1-3 uk-width-large-1-4">
                        <section class="uk-panel footer-infomation">
                            <header class="panel-head"><div class="heading" style="color:#00a651;">{{ $menu['title'] }}</div></header>
                            @if(!empty($menu['items']))
                                <section class="panel-body">
                                    <ul class="uk-list list-article">
                                        @foreach($menu['items'] as $item)
                                            <li><a href="{{ $item['href'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a></li>
                                        @endforeach
                                    </ul>
                                </section>
                            @endif
                        </section>
                    </div>
                @endforeach
                <div class="uk-width-small-1-2 uk-width-large-1-5">
                    <section class="uk-panel footer-connect">
                        <section class="panel-body">
                            <div class="title">Liên kết mạng xã hội</div>
                            <ul class="uk-list uk-clearfix social">
                                <li><a href="{{ $system['social_facebook'] ?? '#' }}" title="facebook"><i class="fa fa-facebook"></i></a></li>
                                <li><a href="{{ $system['social_twitter'] ?? '#' }}" title="twitter"><i class="fa fa-twitter"></i></a></li>
                                <li><a href="{{ $system['social_instagram'] ?? '#' }}" title="instagram"><i class="fa fa-instagram"></i></a></li>
                                <li><a href="{{ $system['social_youtube'] ?? '#' }}" title="youtube"><i class="fa fa-youtube"></i></a></li>
                                <li><a href="{{ $system['social_google'] ?? '#' }}" title="google"><i class="fa fa-google-plus"></i></a></li>
                            </ul>
                            <div class="bct"><a href="#" title=""><img src="{{ asset('templates/frontend/resources/img/bct.png') }}" alt=""></a></div>
                        </section>
                    </section>
                </div>
            </div>
        </section>
        <section class="bottom">
            <div class="uk-grid lib-grid-20 uk-grid-width-medium-1-2 uk-grid-width-large-1-3 uk-flex-middle">
                <section class="mb15">
                    <div class="logo"><a class="lib-db" href="{{ url('/') }}" title="{{ $system['seo_meta_title'] ?? '' }}"><img src="{{ $system['homepage_logo'] ?? '' }}" alt="{{ $system['seo_meta_title'] ?? '' }}"></a></div>
                </section>
                <section class="company-info mb15">
                    <div class="title"><span>{{ $system['homepage_company'] ?? '' }}</span></div>
                    <div class="info">{!! $system['contact_contact'] ?? $system['contact_address'] ?? '' !!}</div>
                </section>
                <section class="uk-visible-large">
                    <div class="map"><a href="{{ url('lien-he.html') }}"><img src="{{ asset('bd.JPG') }}" alt=""></a></div>
                </section>
            </div>
        </section>
    </div>
</footer>

<a id="goTop" class="goTop" href="#" title="Về đầu trang">Lên đầu trang</a>
<div class="support-fx hide">
    <section class="support">
        <header class="panel-head">
            <div class="heading"><span>Hỗ trợ trực tuyến</span></div>
            <div class="hotline">
                <a class="phone_number" href="tel:{{ $system['contact_hotline'] ?? '' }}">{{ $system['contact_hotline'] ?? '' }}</a>
                <a class="phone_number" href="tel:{{ $system['contact_hotline2'] ?? '' }}">{{ $system['contact_hotline2'] ?? '' }}</a>
            </div>
        </header>
    </section>
</div>
<div class="zalo_phone"><a href="https://zalo.me/{{ $system['contact_zalo'] ?? '' }}" target="_blank"></a></div>
<div class="giuseart-nav">
    <ul>
        <li><a href="https://g.page/nhualaysang?share" rel="nofollow" target="_blank"><i class="ticon-heart"></i>Tìm đường</a></li>
        <li><a href="https://zalo.me/{{ $system['contact_zalo'] ?? '' }}" rel="nofollow" target="_blank"><i class="ticon-zalo-circle2"></i>Chat Zalo</a></li>
        <li class="phone-mobile"><a href="tel:{{ $system['contact_hotline'] ?? '' }}" rel="nofollow" class="button"><span class="phone_animation animation-shadow"><i class="icon-phone-w"></i></span><span class="btn_phone_txt">Gọi điện</span></a></li>
        <li><a href="https://m.me/NhuaLaySangVinLite" rel="nofollow" target="_blank"><i class="ticon-messenger"></i>Messenger</a></li>
        <li><a href="sms:{{ $system['contact_hotline'] ?? '' }}" class="chat_animation"><i class="ticon-chat-sms"></i>Nhắn tin SMS</a></li>
    </ul>
</div>
<style>
    .zalo_phone{position:fixed;bottom:100px;left:25px;z-index:2147483647;color:#fff;padding:7px 18px 8px;background:#0d94e4 url(https://ssl.vn/wp-content/uploads/2021/03/icon_page.png) -1px -55px no-repeat;border-radius:43px;width:44px;height:44px}
    .zalo_phone a{color:#fff!important;font-weight:bold;width:44px;height:44px;float:left}
    .phone-mobile{display:none}
    .giuseart-nav{position:fixed;left:13px;background:#fff;border-radius:5px;width:auto;z-index:150;bottom:50px;padding:10px 0;border:1px solid #f2f2f2}
    .giuseart-nav ul{list-style:none;padding:0;margin:0}.giuseart-nav ul li{list-style:none!important}.giuseart-nav ul>li a{border:none;padding:3px;display:block;border-radius:5px;text-align:center;font-size:10px;line-height:15px;color:#515151;font-weight:700;max-width:72.19px;max-height:54px;text-decoration:none}
    .giuseart-nav ul>li .chat_animation{display:none}.giuseart-nav ul>li a i{width:36px;height:36px;display:block;margin:auto;background-size:contain!important}
    .giuseart-nav ul>li a i.ticon-heart{background:url({{ asset('icon-map.png') }}) no-repeat}.giuseart-nav ul>li a i.ticon-zalo-circle2{background:url({{ asset('icon-zalo.png') }}) no-repeat}.giuseart-nav ul>li a i.ticon-messenger{background:url({{ asset('icon-messenger.png') }}) no-repeat}.giuseart-nav ul>li a i.ticon-chat-sms{background:url({{ asset('icon-sms-1.jpg') }}) no-repeat}.giuseart-nav ul>li a i.icon-phone-w{background:url({{ asset('icon-phone-w.png') }}) no-repeat}
    @media (min-width:800px){.giuseart-nav{display:none!important}}
    @media only screen and (max-width:600px){.phone-mobile{display:block!important}.giuseart-nav{background:#fff;width:100%;border-radius:0;height:60px;line-height:50px;position:fixed;bottom:0;left:0;z-index:999;padding:5px;margin:0;box-shadow:0 4px 10px 0 #000}.giuseart-nav li{float:left;width:20%;height:50px}.giuseart-nav ul>li .chat_animation{display:block}.zalo_phone,.support-fx{display:none}}
</style>

@extends('frontend.homepage.layout')
@section('content')
@php
    $albums = json_decode($DetailProducts['albums'] ?? '[]', true) ?: [];
    $canonicalUrl = $seo['canonical'] ?? rewrite_url($DetailProducts['canonical'] ?? '');
@endphp
<div class="breadcrumb">
    <div class="uk-container uk-container-center">
        <ul class="uk-breadcrumb">
            <li><a href="{{ url('/') }}" title="Trang chủ">Trang chủ</a></li>
            @foreach($Breadcrumb ?? [] as $item)
                <li><a href="{{ rewrite_url($item['canonical'] ?? '') }}" title="{{ $item['title'] ?? '' }}">{{ $item['title'] ?? '' }}</a></li>
            @endforeach
        </ul>
    </div>
</div>
<section class="main-content">
    <div class="uk-container uk-container-center">
        <section class="product-detail">
            <section class="panel-body">
                <div class="uk-grid uk-grid-width-large-1-2">
                    <script>
                        $(window).on('load', function(){
                            $('#carousel').flexslider({animation:"slide",controlNav:false,itemWidth:150,animationLoop:false,prevText:"",nextText:"",slideshow:false,asNavFor:'#slider'});
                            $('#slider').flexslider({animation:"slide",controlNav:false,animationLoop:false,slideshow:false,prevText:"",nextText:"",sync:"#carousel"});
                        });
                    </script>

                    @if(count($albums))
                        <section class="productDetail-gallery">
                            <div id="slider" class="flexslider">
                                <ul class="slides">
                                    <li><a href="{{ $DetailProducts['images'] }}" class="img-scaledown image" data-uk-lightbox="{group:'#product-gallery'}"><img src="{{ $DetailProducts['images'] }}" alt="{{ $DetailProducts['title'] }}"></a></li>
                                    @foreach($albums as $album)
                                        @php $albumImage = $album['images'] ?? $album['image'] ?? ''; @endphp
                                        @if($albumImage)
                                            <li><a href="{{ getthumb($albumImage) }}" class="img-scaledown image" data-uk-lightbox="{group:'#product-gallery'}"><img src="{{ getthumb($albumImage) }}" alt="{{ $DetailProducts['title'] }}"></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                            <div id="carousel" class="flexslider uk-margin-bottom-remove">
                                <ul class="slides">
                                    <li><a href="#" class="img-scaledown image"><img src="{{ $DetailProducts['images'] }}" alt="{{ $DetailProducts['title'] }}"></a></li>
                                    @foreach($albums as $album)
                                        @php $albumImage = $album['images'] ?? $album['image'] ?? ''; @endphp
                                        @if($albumImage)
                                            <li><a href="#" class="img-scaledown image"><img src="{{ getthumb($albumImage) }}" alt="{{ $DetailProducts['title'] }}"></a></li>
                                        @endif
                                    @endforeach
                                </ul>
                            </div>
                        </section>
                    @else
                        <div class="mb25"><img src="{{ $DetailProducts['images'] }}" alt="{{ $DetailProducts['title'] }}" class="uk-width-1-1"></div>
                    @endif

                    <section class="productDetail-intro">
                        <h1 class="title">{{ $DetailProducts['title'] }}</h1>
                        @php
                            $price = (float) ($DetailProducts['price'] ?? 0);
                            $saleoff = (float) ($DetailProducts['saleoff'] ?? 0);
                        @endphp
                        <div class="productDetail-price uk-flex uk-flex-middle">
                            @if($price > 0)
                                <div class="product-pricenew">{{ number_format($saleoff > 0 ? $saleoff : $price) }}đ</div>
                                @if($saleoff > 0)
                                    <div class="product-priceold">{{ number_format($price) }}đ</div>
                                    <div class="product-percent">-{{ percent($price, $saleoff) }}%</div>
                                @endif
                            @else
                                <div class="product-pricenew">Liên hệ</div>
                            @endif
                        </div>
                        <div class="productDetail-description">{!! $DetailProducts['description'] ?? '' !!}</div>
                        <div class="productDetail-buy">
                            <form class="uk-form form">
                                <div class="uk-flex uk-flex-middle uk-flex-space-between box">
                                    <div class="quantity uk-flex uk-flex-middle">
                                        <span class="label">Số lượng</span>
                                        <div>
                                            <input type="text" value="1" class="input-text quantity-input">
                                            <span class="btn btn-up"><i class="fa fa-caret-up"></i></span>
                                            <span class="btn btn-down"><i class="fa fa-caret-down"></i></span>
                                        </div>
                                    </div>
                                    <div class="action">
                                        <a class="link addtocart btn btn-addtocart" href="#" data-quantity="1" title="Thêm giỏ hàng" id="ajax-addtocart" data-id="{{ $DetailProducts['id'] }}" data-price="{{ $DetailProducts['price'] }}">Thêm giỏ hàng</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </section>
                </div>

                <div class="uk-grid uk-grid-medium">
                    <div class="uk-width-large-3-4 uk-width-xlarge-4-5">
                        <section class="product-content">
                            <ul class="uk-list uk-clearfix tab-control" data-uk-switcher="{connect:'#tab-content'}">
                                <li class="uk-active">Mô tả sản phẩm</li>
                                <li>Đánh giá sản phẩm</li>
                                <li>Video</li>
                            </ul>
                            <ul id="tab-content" class="uk-switcher tab-content">
                                <li>
                                    <div id="tocDiv"><ol id="tocListAncarat"></ol></div>
                                    <article class="article content-detail-new">{!! $DetailProducts['content'] ?? '' !!}</article>
                                </li>
                                <li><div class="comments"><div class="fb-comments" data-href="{{ $canonicalUrl }}" data-width="100%" data-numposts="3"></div></div></li>
                                <li>{!! $DetailProducts['videos'] ?? '' !!}</li>
                            </ul>
                        </section>
                    </div>
                    <div class="uk-width-large-1-4 uk-width-xlarge-1-5">
                        <aside class="aside">
                            @if(!empty($Seen))
                                <section class="aside-panel panel-products aside-randomproduct">
                                    <header class="panel-head"><div class="heading-3"><span>Sản phẩm đã xem</span></div></header>
                                    <section class="panel-body">
                                        <div class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-1 list-product">
                                            @foreach($Seen as $product)
                                                @include('frontend.component.legacy-product-item', ['product' => $product])
                                            @endforeach
                                        </div>
                                    </section>
                                </section>
                            @endif
                        </aside>
                    </div>
                </div>
            </section>
        </section>

        @if(!empty($products_same))
            <section class="panel-products productCatalogue">
                <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                    <h2 class="heading-1"><a href="{{ $canonicalUrl }}" title="Sản phẩm cùng chuyên mục">Sản phẩm cùng chuyên mục</a></h2>
                </header>
                <section class="panel-body">
                    <div class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 uk-grid-width-xlarge-1-5 list-product">
                        @foreach($products_same as $product)
                            @include('frontend.component.legacy-product-item', ['product' => $product])
                        @endforeach
                    </div>
                </section>
            </section>
        @endif
    </div>
</section>
<style>
    .article iframe,#tab-content iframe,#tab-content img,.content-detail-new img,.content-detail-new iframe{max-width:100%!important;height:auto!important}
    #tocDiv{width:auto;margin-bottom:20px}
    #tocDiv #tocListAncarat{border-radius:7px;padding-top:10px;padding-right:10px;padding-left:25px;list-style:decimal}
</style>
<script>
    $(document).ready(function(){
        $('.quantity-input').change(function(){ $('.addtocart').attr('data-quantity', $(this).val()); });
        $('.btn-up').click(function(){ var q = parseInt($('.quantity-input').val() || 1) + 1; $('.quantity-input').val(q); $('.addtocart').attr('data-quantity', q); });
        $('.btn-down').click(function(){ var q = Math.max(1, parseInt($('.quantity-input').val() || 1) - 1); $('.quantity-input').val(q); $('.addtocart').attr('data-quantity', q); });
    });
</script>
@endsection

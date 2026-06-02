@extends('frontend.homepage.layout')
@section('content')
<h1 style="display:none">{{ $system['seo_meta_title'] ?? '' }}</h1>
<section class="main-content">
    <section class="home-topcontent">
        <div class="uk-container uk-container-center">
            <div class="container">
                <div class="slideshow_product">
                    @include('frontend.component.main-slide')

                    @if(!empty($highlight_product))
                        <section class="product-highlight">
                            <div class="uk-slidenav-position slider-1" data-uk-slider="{autoplay:true, autoplayInterval:4500}">
                                <div class="uk-slider-container">
                                    <ul class="uk-slider uk-grid uk-grid-small uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4">
                                        @foreach($highlight_product as $product)
                                            @php
                                                $title = $product['title'] ?? '';
                                                $href = rewrite_url($product['canonical'] ?? '');
                                                $image = getthumb($product['images'] ?? null);
                                                $price = (float) ($product['price'] ?? 0);
                                            @endphp
                                            <li class="product-item">
                                                <div class="wrap-product">
                                                    <div class="product uk-grid uk-grid-collapse col-reverse-479">
                                                        <div class="uk-width-small-3-5">
                                                            <div class="info">
                                                                <h3 class="title lib-line-2"><a href="{{ $href }}" title="{{ $title }}">{{ $title }}</a></h3>
                                                                <div class="price">{{ $price > 0 ? number_format($price).'đ' : 'Liên hệ' }}</div>
                                                                <div class="detail"><a href="{{ $href }}" title="{{ $title }}">Chi tiết <i class="fa fa-angle-double-right"></i></a></div>
                                                            </div>
                                                        </div>
                                                        <div class="uk-width-small-2-5">
                                                            <div class="thumb"><a class="image img-cover" href="{{ $href }}" title="{{ $title }}"><img class="lazy" data-original="{{ $image }}" src="{{ $image }}" alt="{{ $title }}"></a></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </section>

    <div class="uk-container uk-container-center">
        @php
            $promotionBanners = array_filter([
                $system['banner_adv_11'] ?? '',
                $system['banner_adv_22'] ?? '',
                $system['banner_adv_33'] ?? '',
            ]);
            $promotionTitle = $saleoff_product[0]['title'] ?? 'Sản phẩm khuyến mại';
            $promotionHref = rewrite_url($saleoff_product[0]['canonical'] ?? '#', null, null, null, false, false);
        @endphp
        @if(count($promotionBanners))
            <section class="promotional-product uk-hidden-small">
                <header class="panel-head skin-1"><h2 class="heading-1"><a href="{{ $promotionHref }}" title="{{ $promotionTitle }}">{{ $promotionTitle }}</a></h2></header>
                <section class="panel-body">
                    <div class="uk-grid lib-grid-20 uk-grid-width-small-1-2 uk-grid-width-medium-1-3">
                        @foreach($promotionBanners as $banner)
                            <div class="item">
                                <div class="banner"><img class="lazy" data-original="{{ getthumb($banner) }}" src="{{ getthumb($banner) }}" alt=""></div>
                            </div>
                        @endforeach
                    </div>
                </section>
            </section>
        @endif

        @if(!empty($product_catalogues_is))
            @foreach($product_catalogues_is as $catalogue)
                @php
                    $titleC = $catalogue['title'] ?? '';
                    $hrefC = rewrite_url($catalogue['canonical'] ?? '');
                @endphp
                <section class="panel-products home home-productCatalogue">
                    <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                        <h2 class="heading-1"><a href="{{ $hrefC }}" title="{{ $titleC }}">{{ $titleC }}</a></h2>
                        @if(!empty($catalogue['child']))
                            <ul class="uk-list uk-clearfix listCat uk-visible-large">
                                @foreach($catalogue['child'] as $child)
                                    <li><a href="{{ rewrite_url($child['canonical'] ?? '') }}" title="{{ $child['title'] ?? '' }}">{{ $child['title'] ?? '' }}</a></li>
                                @endforeach
                            </ul>
                        @endif
                        <div class="viewmore uk-hidden-large"><a href="{{ $hrefC }}" title="{{ $titleC }}">Xem tất cả <i class="fa fa-angle-double-right"></i></a></div>
                    </header>
                    <section class="panel-body">
                        <div class="uk-grid lib-grid-20">
                            <div class="uk-width-large-1-5 lib-visible-xlarge">
                                <div class="banner img-cover"><a href="{{ $hrefC }}" title="{{ $titleC }}"><img class="lazy" data-original="{{ getthumb($catalogue['images'] ?? null) }}" src="{{ getthumb($catalogue['images'] ?? null) }}" alt="{{ $titleC }}"></a></div>
                            </div>
                            <div class="uk-width-xlarge-4-5">
                                @if(!empty($catalogue['post']))
                                    <div class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-large-1-4 list-product" data-uk-grid-match="{target:'.product-1 .product-title'}">
                                        @foreach($catalogue['post'] as $product)
                                            @include('frontend.component.legacy-product-item', ['product' => $product])
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                        </div>
                    </section>
                </section>
            @endforeach
        @endif

        <div class="uk-grid uk-grid-medium uk-grid-width-large-1-2">
            @foreach($product_catalogues_hl ?? [] as $catalogue)
                @php $href = rewrite_url($catalogue['canonical'] ?? ''); @endphp
                <section class="panel-products home home-productCatalogue skin-1">
                    <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                        <h2 class="heading-1"><a href="{{ $href }}" title="{{ $catalogue['title'] ?? '' }}">{{ $catalogue['title'] ?? '' }}</a></h2>
                        <div class="viewmore"><a href="{{ $href }}" title="{{ $catalogue['title'] ?? '' }}">Xem tất cả <i class="fa fa-angle-double-right"></i></a></div>
                    </header>
                    @if(!empty($catalogue['post']))
                        <section class="panel-body">
                            <div class="uk-grid lib-grid-15 uk-grid-width-1-2 list-product" data-uk-grid-match="{target:'.product-1 .product-title'}">
                                @foreach($catalogue['post'] as $product)
                                    @include('frontend.component.legacy-product-item', ['product' => $product, 'skinClass' => 'skin-1'])
                                @endforeach
                            </div>
                        </section>
                    @endif
                </section>
            @endforeach
        </div>

        <div class="uk-grid uk-grid-medium">
            <div class="uk-width-large-3-4">
                @foreach($news ?? [] as $catalogue)
                    @php $href = rewrite_url($catalogue['canonical'] ?? ''); @endphp
                    <section class="article-catalogue-1">
                        <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                            <h2 class="heading-1"><a href="{{ $href }}" title="{{ $catalogue['title'] ?? '' }}">{{ $catalogue['title'] ?? '' }}</a></h2>
                            @if(!empty($catalogue['child']))
                                <ul class="uk-list uk-clearfix listCat uk-visible-large">
                                    @foreach($catalogue['child'] as $child)
                                        <li><a href="{{ rewrite_url($child['canonical'] ?? '') }}" title="{{ $child['title'] ?? '' }}">{{ $child['title'] ?? '' }}</a></li>
                                    @endforeach
                                </ul>
                            @endif
                        </header>
                        @if(!empty($catalogue['post']))
                            <section class="panel-body">
                                <div class="uk-grid uk-grid-medium">
                                    <div class="uk-width-xlarge-2-3">
                                        @foreach(array_slice($catalogue['post'], 0, 1) as $post)
                                            @php
                                                $postHref = rewrite_url($post['canonical'] ?? '');
                                                $postImage = getthumb($post['images'] ?? null);
                                            @endphp
                                            <article class="featured article">
                                                <h3 class="article-title"><a href="{{ $postHref }}" title="{{ $post['title'] ?? '' }}">{{ $post['title'] ?? '' }}</a></h3>
                                                <div class="article-thumb"><a class="article-image img-cover" href="{{ $postHref }}" title="{{ $post['title'] ?? '' }}"><img class="lazy" data-original="{{ $postImage }}" src="{{ $postImage }}" alt="{{ $post['title'] ?? '' }}"></a></div>
                                                <div class="article-info">
                                                    <div class="article-meta"><img src="{{ asset('templates/frontend/resources/img/calendar.png') }}" alt="">Ngày đăng: {{ $post['created'] ?? '' }}</div>
                                                    <div class="article-description">{{ cutnchar(strip_tags($post['description'] ?? ''), 1000) }}</div>
                                                </div>
                                            </article>
                                        @endforeach
                                    </div>
                                    <div class="uk-width-xlarge-1-3">
                                        <div class="uk-grid ec-grid-20 uk-grid-width-small-1-2 uk-grid-width-xlarge-1-1 list-article">
                                            @foreach(array_slice($catalogue['post'], 1) as $post)
                                                <div class="article-item">@include('frontend.component.legacy-article-item', ['post' => $post, 'descriptionLength' => 0])</div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </section>
                        @endif
                    </section>
                @endforeach
            </div>
            <div class="uk-width-large-1-4 uk-visible-large">
                @include('frontend.component.aside-2')
            </div>
        </div>
    </div>
</section>
@endsection

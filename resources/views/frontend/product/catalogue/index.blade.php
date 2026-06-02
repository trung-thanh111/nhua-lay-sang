@extends('frontend.homepage.layout')
@section('content')
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
<section class="main-content modules-products">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-collapse col-reverse-959">
            <div class="uk-width-large-1-4 uk-width-xlarge-1-5">
                @include('frontend.component.legacy-product-sidebar')
            </div>
            <div class="uk-width-large-3-4 uk-width-xlarge-4-5">
                <div class="rightContent">
                    @if(!empty($DetailCatalogues['banner_3']))
                        <div class="productCatalogue-banner ec-cover">{!! $DetailCatalogues['banner_3'] !!}</div>
                    @endif

                    @if(!empty($child))
                        @foreach($child as $catalogue)
                            @php
                                $titleC = $catalogue['title'] ?? '';
                                $hrefC = rewrite_url($catalogue['canonical'] ?? '');
                                $items = $catalogue['post'] ?? [];
                            @endphp
                            <section class="panel-products productCatalogue">
                                <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                                    <h1 class="heading-1"><a href="{{ $hrefC }}" title="{{ $titleC }}">{{ $titleC }}</a></h1>
                                    <div class="viewmore uk-hidden-large"><a href="{{ $hrefC }}" title="{{ $titleC }}">Xem tất cả <i class="fa fa-angle-double-right"></i></a></div>
                                </header>
                                <section class="panel-body">
                                    @if(count($items))
                                        <div class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-4 list-product" data-uk-grid-match="{target:'.product-1 .product-title'}">
                                            @foreach($items as $product)
                                                @include('frontend.component.legacy-product-item', ['product' => $product])
                                            @endforeach
                                        </div>
                                    @else
                                        <p style="color:#666;">Dữ liệu đang được cập nhật...</p>
                                    @endif
                                    @if(!empty($catalogue['description']))
                                        <hr>{!! $catalogue['description'] !!}
                                    @endif
                                </section>
                            </section>
                        @endforeach
                    @elseif(!empty($productsList))
                        <section class="panel-products productCatalogue">
                            <header class="panel-head skin-1 uk-flex uk-flex-middle uk-flex-space-between">
                                <h1 class="heading-1"><a href="{{ $seo['canonical'] ?? '#' }}" title="{{ $DetailCatalogues['title'] ?? '' }}">{{ $DetailCatalogues['title'] ?? '' }}</a></h1>
                            </header>
                            <section class="panel-body">
                                <div class="uk-grid lib-grid-15 uk-grid-width-1-2 uk-grid-width-medium-1-3 uk-grid-width-xlarge-1-4 list-product" data-uk-grid-match="{target:'.product-1 .product-title'}">
                                    @foreach($productsList as $product)
                                        @include('frontend.component.legacy-product-item', ['product' => $product])
                                    @endforeach
                                </div>
                                {!! $PaginationList ?? '' !!}
                            </section>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .panel-body img{max-width:100%!important;height:auto!important}
    .panel-body ul li{white-space:inherit!important}
</style>
@endsection

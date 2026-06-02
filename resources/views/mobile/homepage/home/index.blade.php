@extends('mobile.homepage.layout')
@section('content')
@include('mobile.homepage.component.slide-index')

@if(!empty($highlight_product))
    <section class="block margin-bottom-20 uk-margin-top">
        <div class="uk-container uk-container-center">
            <div class="uk-panel">
                <header class="uk-clearfix"><h3 class="block-title uk-margin-remove uk-float-left"><span class="fc-text-uppercase">Sản phẩm mới</span></h3></header>
                <div class="fc-body">
                    <div class="uk-grid uk-grid-small uk-grid-width-medium-1-3 uk-grid-width-small-1-2" data-uk-grid-match="{target:'.fc-product-title'}">
                        @foreach($highlight_product as $product)
                            @include('mobile.component.product-card', ['product' => $product])
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

@foreach($product_catalogues_is ?? [] as $catalogue)
    @php $hrefC = rewrite_url($catalogue['canonical'] ?? ''); @endphp
    <section class="block margin-bottom-20 uk-margin-top">
        <div class="uk-container uk-container-center">
            <div class="uk-panel">
                <header class="uk-clearfix">
                    <h3 class="block-title uk-margin-remove uk-float-left"><a href="{{ $hrefC }}" title="{{ $catalogue['title'] ?? '' }}" class="fc-text-uppercase">{{ $catalogue['title'] ?? '' }}</a></h3>
                    @if(!empty($catalogue['child']))
                        <div class="uk-button-dropdown uk-float-right" data-uk-dropdown="{mode:'click',pos:'bottom-right'}">
                            <a href="#" class="trigger"><i class="uk-icon-bars"></i></a>
                            <div class="uk-dropdown">
                                <ul class="uk-list uk-panel fc-list uk-margin-remove uk-padding-remove">
                                    @foreach($catalogue['child'] as $child)
                                        <li class="lvl-1"><a href="{{ rewrite_url($child['canonical'] ?? '') }}" class="lvl-1" title="{{ $child['title'] ?? '' }}">{{ $child['title'] ?? '' }}</a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif
                </header>
                @if(!empty($catalogue['post']))
                    <div class="fc-body">
                        <div class="uk-grid uk-grid-small uk-grid-width-medium-1-3 uk-grid-width-small-1-2">
                            @foreach($catalogue['post'] as $product)
                                @include('mobile.component.product-card', ['product' => $product])
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
@endforeach

@foreach($news ?? [] as $catalogue)
    <section class="block articles uk-margin-top margin-bottom-25">
        <div class="uk-container uk-container-center">
            <div class="uk-panel">
                <h3 class="heading uk-clearfix fc-text-uppercase"><a href="{{ rewrite_url($catalogue['canonical'] ?? '') }}" title="{{ $catalogue['title'] ?? '' }}">{{ $catalogue['title'] ?? '' }}</a></h3>
                @foreach(array_slice($catalogue['post'] ?? [], 0, 3) as $post)
                    @php $href = rewrite_url($post['canonical'] ?? ''); @endphp
                    <div class="fc-featured uk-clearfix">
                        <a href="{{ $href }}" title="{{ $post['title'] ?? '' }}" class="fc-thumb"><img src="{{ getthumb($post['images'] ?? null) }}" alt="{{ $post['title'] ?? '' }}"></a>
                        <div class="fc-info">
                            <h3 class="title uk-margin-remove"><a href="{{ $href }}" title="{{ $post['title'] ?? '' }}" class="uk-text-bold">{{ $post['title'] ?? '' }}</a></h3>
                            <span class="uk-text-muted fc-article-meta">{{ $post['created'] ?? '' }}</span>
                            <div class="fc-article-desc">{{ cutnchar(strip_tags($post['description'] ?? ''), 250) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endforeach
@endsection

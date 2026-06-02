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
<section class="main-content">
    <div class="uk-container uk-container-center">
        <div class="uk-grid uk-grid-medium">
            <div class="uk-width-large-2-3">
                <section class="listArticleCatalogue">
                    <header class="panel-head skin-1">
                        <h1 class="heading-1"><span>{{ $DetailCatalogues['title'] ?? '' }}</span></h1>
                    </header>
                    @if(!empty($ArticlesList))
                    <section class="panel-body">
                        <div class="uk-grid uk-grid-medium">
                            <div class="uk-width-medium-2-3">
                                <ul class="uk-list listArticle">
                                    @foreach($ArticlesList as $post)
                                    @php
                                        $title = $post['title'] ?? '';
                                        $href = rewrite_url($post['canonical'] ?? '');
                                        $image = getthumb($post['images'] ?? null);
                                        $description = cutnchar(strip_tags($post['description'] ?? ''), 250);
                                    @endphp
                                    <div class="article-item">
                                        <article class="article-2 uk-grid uk-grid-collapse">
                                            <div class="uk-width-small-2-5">
                                                <div class="thumb img-flash">
                                                    <a class="image img-cover" href="{{ $href }}" title="{{ $title }}"><img src="{{ $image }}" alt="{{ $title }}"></a>
                                                </div>
                                            </div>
                                            <div class="uk-width-small-3-5">
                                                <div class="info">
                                                    <h2 class="title"><a href="{{ $href }}" title="{{ $title }}">{{ $title }}</a></h2>
                                                    <div class="description">{{ $description }}</div>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="uk-width-medium-1-3">
                                @if(!empty($most_viewed))
                                <section class="mostViewed">
                                    <header class="panel-head">
                                        <div class="heading"><span>Bài đọc nhiều</span></div>
                                    </header>
                                    <section class="panel-body">
                                        <ul class="uk-grid uk-grid-small uk-grid-width-1-2 uk-grid-width-medium-1-1">
                                        @foreach($most_viewed as $post)
                                            @php
                                                $title = $post['title'] ?? '';
                                                $href = rewrite_url($post['canonical'] ?? '');
                                                $image = getthumb($post['images'] ?? null);
                                            @endphp
                                            <div class="article-item">
                                                <article class="article">
                                                    <div class="thumb">
                                                        <a class="image img-cover" href="{{ $href }}" title="{{ $title }}"><img src="{{ $image }}" alt="{{ $title }}"></a>
                                                    </div>
                                                    <h3 class="title"><a href="{{ $href }}" title="{{ $title }}">{{ $title }}</a></h3>
                                                </article>
                                            </div>
                                        @endforeach
                                        </ul>
                                    </section>
                                </section>
                                @endif
                            </div>
                        </div>
                        <div class="pagination">{!! $PaginationList ?? '' !!}</div>
                    </section>
                    @endif
                </section>
            </div>
            <div class="uk-width-large-1-3">
                @include('frontend.component.aside-2')
            </div>
        </div>
    </div>
</section>
@endsection

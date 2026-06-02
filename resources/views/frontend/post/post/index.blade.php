@extends('frontend.homepage.layout')
@section('content')
@php $canonicalUrl = $seo['canonical'] ?? rewrite_url($DetailArticles['canonical'] ?? ''); @endphp
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
            <div class="uk-width-large-1-3">
                <div id="tocDiv" class="hidden-mb hehe"><ol id="tocListAncarat"></ol></div>
                <div class="clearfix"></div>
            </div>
            <div class="uk-width-large-3-3">
                <div class="rightContent">
                    <section class="uk-panel article-detail">
                        <section class="panel-body">
                            <h1 class="title">{{ $DetailArticles['title'] ?? '' }}</h1>
                            <div class="share-box uk-flex uk-flex-middle mb10">
                                <div class="facebook"><div class="fb-like" data-href="{{ $canonicalUrl }}" data-layout="button_count" data-action="like" data-show-faces="true" data-share="true"></div></div>
                            </div>
                            <div class="meta uk-flex uk-flex-middle">
                                <div class="time">Cập nhật: {{ $DetailArticles['created'] ?? '' }}</div>
                                <div class="viewed">Lượt xem: {{ $DetailArticles['viewed'] ?? 0 }}</div>
                            </div>
                            <article class="article">
                                <article class="article content-detail-new hong">{!! $contentWithToc ?? $DetailArticles['content'] ?? '' !!}</article>
                            </article>
                            <div class="comments"><div class="fb-comments" data-href="{{ $canonicalUrl }}" data-width="100%" data-numposts="3"></div></div>
                        </section>
                    </section>
                    @if(!empty($articles_same))
                        <section class="uk-panel article-related">
                            <header class="panel-head skin-1"><div class="heading-1"><span>Các bài viết khác</span></div></header>
                            <section class="panel-body">
                                <ul class="uk-list list-article">
                                    @foreach($articles_same as $post)
                                        <li><a href="{{ rewrite_url($post['canonical'] ?? '') }}" title="{{ $post['title'] ?? '' }}">{{ $post['title'] ?? '' }}</a> <span class="viewed">({{ $post['created'] ?? '' }} - {{ $post['viewed'] ?? 0 }} lượt xem)</span></li>
                                    @endforeach
                                </ul>
                            </section>
                        </section>
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<style>
    .content-detail-new img,.content-detail-new iframe,.article iframe{max-width:100%!important;height:auto!important}
    #tocDiv{width:auto;float:left;margin-bottom:20px}.hehe{position:sticky;top:11px}
    #tocDiv #tocListAncarat{border-radius:7px;padding-top:10px;border:1px solid rgb(222,225,243)!important;padding-right:10px;padding-left:25px;list-style:decimal}
    #tocDiv a{font-size:15px;color:#333;font-weight:400;display:block}
</style>
<script>
    $(document).ready(function(){ tableOfContents("#tocListAncarat"); });
    function tableOfContents(target){
        $(target).empty();
        var prevH2List = null, index = 0;
        $(".content-detail-new h2, .content-detail-new h3").each(function(){
            $(this).before("<a name='"+index+"'></a>");
            var li = "<li><a href='{{ $canonicalUrl }}#"+index+"'>"+$(this).text()+"</a></li>";
            if($(this).is("h2")){ prevH2List = $("<ol></ol>"); var item = $(li); item.append(prevH2List); item.appendTo(target); }
            else if(prevH2List){ prevH2List.append(li); }
            index++;
        });
    }
</script>
@endsection

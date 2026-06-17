@php
    $mainNav = navigations_array('main', $config['language'] ?? 1);
    $productCategories = \App\Support\LegacyFrontend::productAsideCategories($config['language'] ?? 1);
    $commitments = \App\Support\LegacyFrontend::headerCommitments($config['language'] ?? 1);
    $categoryActive = request()->routeIs('home.index') && (($header_active ?? true) !== false);
@endphp
<header class="header" id="header">
    <section class="topbar">
        <div class="uk-container uk-container-center">
            <div class="uk-flex uk-flex-space-between uk-flex-middle container">
                <a href="#offcanvas" class="offcanvas-bar uk-hidden-medium uk-hidden-large" data-uk-offcanvas="{target:'#offcanvas'}">Menu</a>
                @if(count($mainNav))
                    <div class="sitelink uk-hidden-small">
                        <ul class="uk-list uk-clearfix">
                            @foreach($mainNav as $item)
                                <li><a href="{{ $item['href'] }}" title="{{ $item['title'] }}">{{ $item['title'] }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="account_hotline uk-flex">
                    <div class="wrap-hotline uk-visible-large">
                        <div class="hotline">
                            <div class="title">Hotline</div>
                            <a href="tel:{{ $system['contact_hotline'] ?? '' }}" class="number">{{ $system['contact_hotline'] ?? '' }}</a>
                        </div>
                    </div>
                </div>
                <div>
                    <a href="{{ url('gio-hang' . config('apps.general.suffix')) }}"><i class="fa fa-cart-plus"></i></a>
                    <a href="?lang=vietnamese"><img src="{{ asset('templates/backend/images/vietnam.gif') }}" alt="vietnamese"></a>
                </div>
            </div>
        </div>
    </section>

    <section class="middle uk-visible-large">
        <div class="uk-container uk-container-center">
            <div class="container uk-flex uk-flex-middle uk-flex-space-between">
                <div class="logo">
                    <a href="{{ url('/') }}" title="{{ $system['seo_meta_title'] ?? '' }}">
                        <img class="lazy" data-original="{{ $system['homepage_logo'] ?? '' }}" src="{{ $system['homepage_logo'] ?? '' }}" alt="{{ $system['seo_meta_title'] ?? '' }}">
                    </a>
                </div>
                @if(count($commitments))
                    <div class="commitment uk-flex uk-flex-middle uk-flex-space-between uk-visible-large">
                        @foreach($commitments as $item)
                            @php
                                $href = rewrite_url($item['canonical'] ?? '');
                                $image = getthumb($item['images'] ?? null);
                                $title = $item['title'] ?? '';
                            @endphp
                            <div class="commitment-item">
                                <a href="{{ $href }}" title="{{ $title }}" class="content uk-flex uk-flex-middle">
                                    <div class="icon"><img src="{{ $image }}" alt="{{ $title }}"></div>
                                    <div class="text">
                                        <div class="title">{{ $title }}</div>
                                        <div class="subtitle">{{ cutnchar(strip_tags($item['description'] ?? ''), 250) }}</div>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>
    </section>

    <div class="uk-container uk-container-center uk-visible-large">
        <section class="bottom">
            <div class="uk-grid uk-grid-collapse uk-flex-middle container">
                <div class="uk-width-1-2 uk-width-large-1-10 lib-hidden-xlarge">
                    <a href="#offcanvas-2" class="offcanvas-bar" data-uk-offcanvas="{target:'#offcanvas-2'}">Danh mục</a>
                </div>
                <div class="uk-width-xlarge-1-5 lib-visible-xlarge">
                    <section class="main-categories {{ $categoryActive ? 'active' : '' }}">
                        <header class="panel-head">
                            <div class="heading"><a href="" onclick="return false;" title="DANH MỤC SẢN PHẨM">DANH MỤC SẢN PHẨM</a></div>
                        </header>
                        @if(($modules ?? '') === 'products_catalogues')
                            @include('frontend.component.categories-2')
                        @else
                            @include('frontend.component.categories')
                        @endif
                    </section>
                </div>
                <div class="uk-width-large-7-10 uk-width-xlarge-3-5 uk-visible-large">
                    <div class="search">
                        <form action="{{ url('tim-kiem') }}" method="get" class="form" id="searchForm">
                            <div class="uk-grid uk-grid-collapse">
                                <div class="uk-width-1-3">
                                    <label class="label label-select">
                                        <select name="catalogueid" class="form-select uk-width-1-1">
                                            <option value="0">Chọn Danh mục</option>
                                            @foreach($productCategories as $cat)
                                                <option value="{{ $cat['id'] }}" @selected(request('catalogueid') == $cat['id'])>{{ $cat['title'] }}</option>
                                            @endforeach
                                        </select>
                                    </label>
                                </div>
                                <div class="uk-width-2-3">
                                    <div class="serch-action">
                                        <input type="text" name="keyword" value="{{ request('keyword') }}" class="input-text uk-width-1-1 keyword" autocomplete="off" placeholder="Nhập từ khóa tìm kiếm">
                                        <input type="submit" class="btn-submit" value="Tìm kiếm">
                                    </div>
                                </div>
                            </div>
                            <div class="searchResult"></div>
                        </form>
                    </div>
                </div>
                <div class="uk-width-1-2 uk-width-large-2-10 uk-width-xlarge-1-5">
                    <div style="text-align:center;">
                        <a href="{{ url('gio-hang' . config('apps.general.suffix')) }}" style="color:#ff0000;font-size:28px;float:left;padding-left:20px;"><i class="fa fa-cart-plus"></i></a>
                        <a href="?lang=vietnamese"><img src="{{ asset('templates/backend/images/vietnam.gif') }}" alt="vietnamese"></a>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div class="uk-container uk-container-center uk-hidden-large">
        <section class="upper-small">
            <a href="#offcanvas-2" class="offcanvas-bar btn-catmenu" data-uk-offcanvas="{target:'#offcanvas-2'}">Danh mục</a>
            <div class="logo"><a href="{{ url('/') }}" title="{{ $system['seo_meta_title'] ?? '' }}"><img src="{{ $system['homepage_logo'] ?? '' }}" alt="{{ $system['seo_meta_title'] ?? '' }}"></a></div>
        </section>
        <section class="lower-small">
            <div class="header-searchSmall header">
                <form action="{{ url('tim-kiem') }}" method="get" class="uk-form form searchForm">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" class="uk-width-1-1 input-text keyword" placeholder="Nhập từ khóa tìm kiếm..." style="padding-top:16px;">
                    <button type="submit" class="btn-submit"><i class="fa fa-search"></i></button>
                </form>
            </div>
        </section>
    </div>
</header>
<script>
    $(function(){
        $('.searchForm, #searchForm').on('submit', function(){
            var keyword = $(this).find('.keyword').val();
            if(keyword === ''){ alert('Bạn phải nhập từ khóa'); return false; }
        });
    });
</script>

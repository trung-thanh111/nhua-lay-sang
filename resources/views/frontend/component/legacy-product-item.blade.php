@php
    $title = $product['title'] ?? '';
    $href = rewrite_url($product['canonical'] ?? '');
    $image = getthumb($product['images'] ?? null);
    $price = (float) ($product['price'] ?? 0);
    $saleoff = (float) ($product['saleoff'] ?? 0);
    $percent = percent($price, $saleoff);
    $skinClass = $skinClass ?? '';
@endphp
<div class="product-item">
    <div class="product-1 {{ $skinClass }} {{ $saleoff > 0 ? 'double' : '' }}">
        <div class="product-thumb img-shine">
            <a class="product-image img-cover" href="{{ $href }}" title="{{ $title }}"><img class="lazy" data-original="{{ $image }}" src="{{ $image }}" alt="{{ $title }}"></a>
        </div>
        <div class="product-info">
            <h3 class="product-title"><a href="{{ $href }}" title="{{ $title }}">{{ $title }}</a></h3>
            @if(!empty($product['code']))
                <div class="product-code">Mã sản phẩm: {{ $product['code'] }}</div>
            @endif
            <div class="product-price_sale uk-flex uk-flex-middle uk-flex-space-between">
                @if($price > 0)
                    <div class="product-pricenew">{{ number_format($saleoff > 0 ? $saleoff : $price) }}đ</div>
                    @if($saleoff > 0)
                        <div class="product-priceold">{{ number_format($price) }}đ</div>
                        <div class="product-percent">-{{ $percent }}%</div>
                    @endif
                @else
                    <div class="product-pricenew">Liên hệ</div>
                @endif
            </div>
        </div>
    </div>
</div>

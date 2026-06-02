@if ($paginator->hasPages())
<ul class="uk-pagination uk-display-inline-block">
    @foreach ($paginator->getUrlRange(max(1, $paginator->currentPage() - 2), min($paginator->lastPage(), $paginator->currentPage() + 2)) as $page => $url)
        <li class="{{ $page === $paginator->currentPage() ? 'uk-active' : '' }}">
            <a href="{{ pagination_legacy_url($url, $page) }}">{{ $page }}</a>
        </li>
    @endforeach

    @if ($paginator->hasMorePages())
        <li>
            <a href="{{ pagination_legacy_url($paginator->nextPageUrl(), $paginator->currentPage() + 1) }}" aria-label="Trang sau">&rsaquo;</a>
        </li>
    @endif

    @if ($paginator->currentPage() < $paginator->lastPage())
        <li class="pagination-last">
            <a href="{{ pagination_legacy_url($paginator->url($paginator->lastPage()), $paginator->lastPage()) }}">Trang Cuối &rsaquo;</a>
        </li>
    @endif
</ul>
@endif

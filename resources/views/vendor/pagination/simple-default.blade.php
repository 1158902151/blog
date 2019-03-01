<style>
    .pagination > li{float:left;margin: 10px;font-size: 18px;}
</style>
@if ($paginator->hasPages())
    <ul class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <li class="disabled"><span>首页</span></li>
        @else
            <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">上一页</a></li>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">下一页</a></li>
        @else
            <li class="disabled"><span>尾页</span></li>
        @endif
    </ul>
@endif

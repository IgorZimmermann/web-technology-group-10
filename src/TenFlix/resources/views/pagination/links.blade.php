@if ($paginator->hasPages())
    <nav class="pagination">
        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="disabled">Previous</span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev">
                Previous
            </a>
        @endif

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next">
                Next
            </a>
        @else
            <span class="disabled">Next</span>
        @endif
    </nav>
@endif

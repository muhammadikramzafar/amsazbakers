@if ($paginator->hasPages())
<nav class="pagination" role="navigation" aria-label="Pagination">

  {{-- Previous --}}
  @if ($paginator->onFirstPage())
    <span class="pagination__btn pagination__btn--disabled" aria-disabled="true" aria-label="Previous page">
      <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
      </svg>
    </span>
  @else
    <a class="pagination__btn" href="{{ $paginator->previousPageUrl() }}" rel="prev" aria-label="Previous page">
      <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"/>
      </svg>
    </a>
  @endif

  {{-- Page numbers --}}
  @foreach ($elements as $element)
    @if (is_string($element))
      <span class="pagination__btn pagination__btn--dots" aria-hidden="true">…</span>
    @endif

    @if (is_array($element))
      @foreach ($element as $page => $url)
        @if ($page == $paginator->currentPage())
          <span class="pagination__btn pagination__btn--active" aria-current="page" aria-label="Page {{ $page }}">{{ $page }}</span>
        @else
          <a class="pagination__btn" href="{{ $url }}" aria-label="Go to page {{ $page }}">{{ $page }}</a>
        @endif
      @endforeach
    @endif
  @endforeach

  {{-- Next --}}
  @if ($paginator->hasMorePages())
    <a class="pagination__btn" href="{{ $paginator->nextPageUrl() }}" rel="next" aria-label="Next page">
      <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
      </svg>
    </a>
  @else
    <span class="pagination__btn pagination__btn--disabled" aria-disabled="true" aria-label="Next page">
      <svg viewBox="0 0 20 20" fill="currentColor" width="16" height="16" aria-hidden="true">
        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"/>
      </svg>
    </span>
  @endif

</nav>
@endif

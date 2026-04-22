@if ($paginator->hasPages())
<nav class="flex items-center justify-between text-sm">
    <div class="text-xs text-gray-500">
        Menampilkan {{ $paginator->firstItem() }}–{{ $paginator->lastItem() }} dari {{ $paginator->total() }}
    </div>
    <div class="flex items-center gap-1">
        {{-- Sebelumnya --}}
        @if ($paginator->onFirstPage())
            <span class="px-3 py-1.5 rounded text-xs text-gray-300 cursor-not-allowed">
                <i class="fas fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               class="pagination-link px-3 py-1.5 rounded text-xs text-gray-600 hover:bg-gray-100 transition-colors">
                <i class="fas fa-chevron-left text-[10px] mr-1"></i> Sebelumnya
            </a>
        @endif

        {{-- Nomor Halaman --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span class="px-2 py-1.5 text-xs text-gray-400">{{ $element }}</span>
            @endif

            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span class="px-3 py-1.5 rounded text-xs font-semibold bg-green-600 text-white">{{ $page }}</span>
                    @else
                        <a href="{{ $url }}"
                           class="pagination-link px-3 py-1.5 rounded text-xs text-gray-600 hover:bg-gray-100 transition-colors">{{ $page }}</a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Berikutnya --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               class="pagination-link px-3 py-1.5 rounded text-xs text-gray-600 hover:bg-gray-100 transition-colors">
                Berikutnya <i class="fas fa-chevron-right text-[10px] ml-1"></i>
            </a>
        @else
            <span class="px-3 py-1.5 rounded text-xs text-gray-300 cursor-not-allowed">
                Berikutnya <i class="fas fa-chevron-right text-[10px] ml-1"></i>
            </span>
        @endif
    </div>
</nav>
@endif

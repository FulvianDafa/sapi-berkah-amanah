@extends('layouts.admin')

@section('title', 'Daftar Hewan Kurban')

@section('content')
<div class="space-y-5">

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <h1 class="text-lg font-semibold text-gray-900">Daftar Hewan Kurban</h1>
        <a href="{{ route('admin.hewan-kurban.create') }}" class="btn-primary text-xs self-start">
            <i class="fas fa-plus mr-1.5 text-[11px]"></i> Tambah Hewan
        </a>
    </div>

    <!-- Filter -->
    <div class="bg-white rounded-lg border border-gray-100 p-4">
        <form action="{{ route('admin.hewan-kurban.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 items-end">
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Jenis Hewan</label>
                <select name="jenis_hewan"
                        class="w-full sm:w-40 rounded-md border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/30">
                    <option value="">Semua</option>
                    <option value="sapi" {{ request('jenis_hewan') == 'sapi' ? 'selected' : '' }}>Sapi</option>
                    <option value="kambing" {{ request('jenis_hewan') == 'kambing' ? 'selected' : '' }}>Kambing</option>
                </select>
            </div>
            <div class="w-full sm:w-auto">
                <label class="block text-xs font-medium text-gray-400 uppercase tracking-wide mb-1">Kategori</label>
                <select name="kategori"
                        class="w-full sm:w-44 rounded-md border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/30">
                    <option value="">Semua</option>
                    <option value="prime" {{ request('kategori') == 'prime' ? 'selected' : '' }}>Prime</option>
                    <option value="bigboss" {{ request('kategori') == 'bigboss' ? 'selected' : '' }}>Big Boss</option>
                    <option value="sultan" {{ request('kategori') == 'sultan' ? 'selected' : '' }}>Sultan</option>
                </select>
            </div>
            <div class="flex gap-2">
                <button type="submit" class="btn-primary text-xs">
                    <i class="fas fa-filter mr-1 text-[10px]"></i> Filter
                </button>
                @if(request('jenis_hewan') || request('kategori'))
                    <a href="{{ route('admin.hewan-kurban.index') }}" class="btn-secondary text-xs">Reset</a>
                @endif
            </div>
        </form>
    </div>

    <!-- Table -->
    <div id="table-container">
        <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-sm">
                    <thead>
                        <tr class="border-b border-gray-100">
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400 w-10">No</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400 w-16">Foto</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Nama</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Info</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Harga</th>
                            <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Status</th>
                            <th class="px-4 py-2.5 text-right text-xs font-medium uppercase tracking-wider text-gray-400 w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($hewanKurban as $hewan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-4 py-3 text-gray-400">{{ $loop->iteration }}</td>

                            <!-- Foto -->
                            <td class="px-4 py-3">
                                @if($hewan->photos->isNotEmpty())
                                    <div class="relative group">
                                        <img src="{{ $hewan->photos->first()->url }}"
                                             alt="{{ $hewan->nama }}"
                                             class="h-10 w-10 rounded-md object-cover border border-gray-100">
                                        <div class="hidden group-hover:block absolute z-10 bottom-full left-0 mb-1 p-1 bg-white rounded-lg shadow-lg border border-gray-100">
                                            <img src="{{ $hewan->photos->first()->url }}" class="w-40 h-40 object-cover rounded">
                                        </div>
                                    </div>
                                @else
                                    <div class="h-10 w-10 rounded-md bg-gray-50 flex items-center justify-center">
                                        <i class="fas fa-image text-gray-300 text-xs"></i>
                                    </div>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                <p class="text-sm font-medium text-gray-800">{{ $hewan->nama }}</p>
                                <div class="flex items-center gap-1.5 mt-0.5">
                                    <span class="text-xs text-gray-400">{{ ucfirst($hewan->jenis_hewan) }}</span>
                                    @if($hewan->photos->count() > 0)
                                        <span class="text-xs text-gray-300">·</span>
                                        <span class="text-xs text-gray-400"><i class="fas fa-images text-[10px]"></i> {{ $hewan->photos->count() }}</span>
                                    @endif
                                    @if($hewan->video_url)
                                        <span class="text-xs text-gray-300">·</span>
                                        <a href="{{ $hewan->video_url }}" target="_blank" class="text-xs text-green-600 hover:text-green-700">
                                            <i class="fas fa-play text-[10px]"></i> Video
                                        </a>
                                    @endif
                                </div>
                            </td>

                            <!-- Info -->
                            <td class="px-4 py-3">
                                @if($hewan->kategori)
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium
                                        {{ $hewan->kategori === 'prime'
                                            ? 'bg-sky-50 text-sky-600'
                                            : ($hewan->kategori === 'bigboss'
                                                ? 'bg-green-50 text-green-600'
                                                : 'bg-amber-50 text-amber-600') }}">
                                        {{ $hewan->kategori_label }}
                                    </span>
                                @else
                                    <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-400">Tanpa Kategori</span>
                                @endif
                                <div class="text-xs text-gray-500 mt-1 space-y-0.5">
                                    <div><i class="fas fa-weight-hanging text-gray-400 w-3.5 text-center"></i> {{ $hewan->berat ? $hewan->berat . ' kg' : 'Belum diisi' }}</div>
                                    <div><i class="fas fa-calendar text-gray-400 w-3.5 text-center"></i> {{ $hewan->umur ? $hewan->umur . ' tahun' : 'Belum diisi' }}</div>
                                </div>
                            </td>

                            <!-- Harga -->
                            <td class="px-4 py-3 font-semibold text-gray-800">Rp {{ number_format($hewan->harga, 0, ',', '.') }}</td>

                            <!-- Status -->
                            <td class="px-4 py-3">
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                                    {{ $hewan->status === 'tersedia' ? 'bg-green-50 text-green-700' : 'bg-gray-50 text-gray-500' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $hewan->status === 'tersedia' ? 'bg-green-500' : 'bg-gray-400' }}"></span>
                                    {{ ucfirst($hewan->status) }}
                                </span>
                            </td>

                            <!-- Aksi -->
                            <td class="px-4 py-3">
                                <div class="flex items-center justify-end gap-1">
                                    <a href="{{ route('admin.hewan-kurban.edit', $hewan->id) }}"
                                       class="w-8 h-8 flex items-center justify-center rounded text-amber-500 hover:bg-amber-50 transition-colors"
                                       title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.hewan-kurban.destroy', $hewan->id) }}"
                                          method="POST" class="inline"
                                          onsubmit="return confirm('Hapus data ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit"
                                                class="w-8 h-8 flex items-center justify-center rounded text-red-500 hover:bg-red-50 transition-colors"
                                                title="Hapus">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="px-4 py-12 text-center text-gray-400 text-sm">
                                <i class="fas fa-cow text-2xl text-gray-200 mb-2 block"></i>
                                Belum ada data · <a href="{{ route('admin.hewan-kurban.create') }}" class="text-green-600 hover:underline">Tambah baru</a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($hewanKurban->hasPages())
                <div class="px-4 py-2.5 border-t border-gray-50">
                    {{ $hewanKurban->appends(request()->query())->links('vendor.pagination.simple') }}
                </div>
            @endif
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('click', function(e) {
    const link = e.target.closest('#table-container .pagination-link');
    if (!link) return;

    e.preventDefault();
    const url = link.getAttribute('href');
    const container = document.getElementById('table-container');

    // Loading state
    container.style.opacity = '0.5';
    container.style.pointerEvents = 'none';

    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('table-container');
            if (newTable) {
                container.innerHTML = newTable.innerHTML;
            }
            container.style.opacity = '1';
            container.style.pointerEvents = '';

            // Update URL without reload
            history.pushState(null, '', url);

            // Scroll to table top
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        })
        .catch(() => {
            // Fallback: navigate normally
            window.location.href = url;
        });
});

// Handle browser back/forward
window.addEventListener('popstate', function() {
    const container = document.getElementById('table-container');
    container.style.opacity = '0.5';

    fetch(window.location.href, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const parser = new DOMParser();
            const doc = parser.parseFromString(html, 'text/html');
            const newTable = doc.getElementById('table-container');
            if (newTable) {
                container.innerHTML = newTable.innerHTML;
            }
            container.style.opacity = '1';
        })
        .catch(() => window.location.reload());
});
</script>
@endpush
@endsection
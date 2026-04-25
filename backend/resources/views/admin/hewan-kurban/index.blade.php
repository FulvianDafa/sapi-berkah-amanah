@extends('layouts.admin')

@section('title', 'Daftar Hewan Kurban')

@section('content')
<div class="space-y-5">

    <!-- Header & Filter -->
    <div class="bg-white rounded-xl border border-gray-100 shadow-sm p-5 mb-5">
        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
            <div>
                <h1 class="text-xl font-bold text-gray-900">Daftar Hewan Kurban</h1>
                <p class="text-sm text-gray-500 mt-1">Kelola data sapi dan kambing yang tersedia untuk kurban.</p>
            </div>
            
            <div class="flex flex-col sm:flex-row items-center gap-3 w-full lg:w-auto">
                <form id="filter-form" action="{{ route('admin.hewan-kurban.index') }}" method="GET" class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">
                    <select name="jenis_hewan" id="filter_jenis_hewan" class="w-full sm:w-40 rounded-lg border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/20 bg-gray-50 hover:bg-white transition-colors cursor-pointer">
                        <option value="">Semua Jenis</option>
                        <option value="sapi" {{ request('jenis_hewan') == 'sapi' ? 'selected' : '' }}>Sapi</option>
                        <option value="kambing" {{ request('jenis_hewan') == 'kambing' ? 'selected' : '' }}>Kambing</option>
                        <option value="domba" {{ request('jenis_hewan') == 'domba' ? 'selected' : '' }}>Domba</option>
                    </select>
                    
                    <select name="kategori" id="filter_kategori" class="w-full sm:w-40 rounded-lg border-gray-200 text-sm py-2 px-3 focus:border-green-600 focus:ring-green-600/20 bg-gray-50 hover:bg-white transition-colors cursor-pointer">
                        <option value="">Semua Kategori</option>
                        <option value="prime" {{ request('kategori') == 'prime' ? 'selected' : '' }}>Prime</option>
                        <option value="bigboss" {{ request('kategori') == 'bigboss' ? 'selected' : '' }}>Big Boss</option>
                        <option value="sultan" {{ request('kategori') == 'sultan' ? 'selected' : '' }}>Sultan</option>
                    </select>
                </form>
                
                <a href="{{ route('admin.hewan-kurban.create') }}" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-4 py-2 bg-green-600 hover:bg-green-700 text-white text-sm font-medium rounded-lg transition-colors shadow-sm shadow-green-600/20">
                    <i class="fas fa-plus text-xs"></i> Tambah Hewan
                </a>
            </div>
        </div>
    </div>

    <!-- Table -->
    <div id="table-container">
        <div class="bg-white rounded-xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[800px] text-sm">
                    <thead>
                        <tr class="bg-gray-50/50 border-b border-gray-100">
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Hewan</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Spesifikasi</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-5 py-4 text-left text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-5 py-4 text-right text-xs font-semibold text-gray-500 uppercase tracking-wider w-24">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @forelse ($hewanKurban as $hewan)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            
                            <!-- Hewan (Foto + Nama) -->
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-4">
                                    @if($hewan->photos->isNotEmpty())
                                        <div class="relative group h-12 w-12 flex-shrink-0">
                                            <img src="{{ $hewan->photos->first()->url }}" class="h-12 w-12 rounded-lg object-cover border border-gray-100 shadow-sm">
                                            <div class="hidden group-hover:block absolute z-10 bottom-full left-0 mb-2 p-1 bg-white rounded-xl shadow-xl border border-gray-100">
                                                <img src="{{ $hewan->photos->first()->url }}" class="w-48 h-48 object-cover rounded-lg">
                                            </div>
                                        </div>
                                    @else
                                        <div class="h-12 w-12 rounded-lg bg-gray-50 flex items-center justify-center border border-gray-100 flex-shrink-0">
                                            <i class="fas fa-image text-gray-300"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <p class="font-medium text-gray-900">{{ $hewan->nama }}</p>
                                        <p class="text-xs text-gray-500 mt-0.5 capitalize">{{ $hewan->jenis_hewan }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Kategori -->
                            <td class="px-5 py-4">
                                @if($hewan->kategori)
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-md text-xs font-medium border
                                        {{ $hewan->kategori === 'prime' ? 'bg-sky-50 text-sky-700 border-sky-100' : 
                                          ($hewan->kategori === 'bigboss' ? 'bg-emerald-50 text-emerald-700 border-emerald-100' : 'bg-amber-50 text-amber-700 border-amber-100') }}">
                                        {{ $hewan->kategori_label }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400 italic">Belum diatur</span>
                                @endif
                            </td>

                            <!-- Spesifikasi -->
                            <td class="px-5 py-4">
                                <div class="space-y-1.5 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-weight-hanging text-gray-400 text-[10px] w-3"></i> 
                                        <span>{{ $hewan->berat ? $hewan->berat . ' kg' : '-' }}</span>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-clock text-gray-400 text-[10px] w-3"></i> 
                                        <span>{{ $hewan->umur ? $hewan->umur . ' tahun' : '-' }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Harga -->
                            <td class="px-5 py-4">
                                <span class="font-semibold text-gray-900">Rp {{ number_format($hewan->harga, 0, ',', '.') }}</span>
                            </td>

                            <!-- Status -->
                            <td class="px-5 py-4">
                                <button type="button" 
                                        title="Klik untuk ubah status ke {{ $hewan->status === 'tersedia' ? 'Terjual' : 'Tersedia' }}"
                                        onclick="toggleStatus({{ $hewan->id }}, '{{ $hewan->status === 'tersedia' ? 'terjual' : 'tersedia' }}', this)"
                                        class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium border transition-all hover:shadow-md focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-gray-200 group cursor-pointer
                                        {{ $hewan->status === 'tersedia' ? 'bg-green-50 text-green-700 border-green-200 hover:bg-green-100 hover:border-green-300' : 'bg-red-50 text-red-700 border-red-200 hover:bg-red-100 hover:border-red-300' }}">
                                    <span class="w-1.5 h-1.5 rounded-full {{ $hewan->status === 'tersedia' ? 'bg-green-500' : 'bg-red-500' }}"></span>
                                    {{ ucfirst($hewan->status) }}
                                    <i class="fas fa-exchange-alt text-[9px] opacity-40 group-hover:opacity-100 transition-opacity ml-0.5 {{ $hewan->status === 'tersedia' ? 'text-green-600' : 'text-red-600' }}"></i>
                                </button>
                            </td>

                            <!-- Aksi -->
                            <td class="px-5 py-4">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.hewan-kurban.edit', $hewan->id) }}"
                                       class="w-8 h-8 flex items-center justify-center rounded text-gray-400 hover:text-amber-600 hover:bg-amber-50 transition-colors"
                                       title="Edit">
                                        <i class="fas fa-pen text-xs"></i>
                                    </a>
                                    <form action="{{ route('admin.hewan-kurban.destroy', $hewan->id) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="button" onclick="confirmDelete(this.closest('form'))"
                                                class="w-8 h-8 flex items-center justify-center rounded text-gray-400 hover:text-red-600 hover:bg-red-50 transition-colors"
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
const Toast = Swal.mixin({
    toast: true, position: 'top-end', showConfirmButton: false,
    timer: 3000, timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('mouseenter', Swal.stopTimer);
        toast.addEventListener('mouseleave', Swal.resumeTimer);
    }
});

function toggleStatus(id, newStatus, btn) {
    const originalHtml = btn.innerHTML;
    btn.innerHTML = '<i class="fas fa-circle-notch fa-spin text-[10px]"></i>';
    btn.disabled = true;
    
    // Ambil csrf dari salah satu form delete yang ada di halaman
    const csrfToken = document.querySelector('input[name="_token"]')?.value;
                    
    fetch(`/admin/hewan-kurban/${id}/status`, {
        method: 'PATCH',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ status: newStatus })
    })
    .then(r => r.json())
    .then(data => {
        if(data.success) {
            Toast.fire({ icon: 'success', title: data.message });
            // Refresh tabel menggunakan trigger filter yang sudah ada
            const filterForm = document.getElementById('filter-form');
            if (filterForm) filterForm.dispatchEvent(new Event('change', { bubbles: true }));
        } else {
            throw new Error(data.message);
        }
    })
    .catch(err => {
        btn.innerHTML = originalHtml;
        btn.disabled = false;
        Toast.fire({ icon: 'error', title: err.message || 'Gagal mengubah status' });
    });
}

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

function confirmDelete(form) {
    Swal.fire({
        title: 'Hapus data ini?',
        text: "Data yang dihapus tidak dapat dikembalikan.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#15803d',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Ya, hapus!',
        cancelButtonText: 'Batal'
    }).then((result) => {
        if (result.isConfirmed) {
            showLoading('Menghapus data...');
            form.submit();
        }
    });
}

function showLoading(message = 'Memproses...') {
    Swal.fire({
        html: `
            <div class="flex flex-col items-center gap-3 py-2">
                <div class="w-10 h-10 border-4 border-gray-100 border-t-green-600 rounded-full animate-spin"></div>
                <span class="text-sm font-medium text-gray-700">${message}</span>
            </div>
        `,
        allowOutsideClick: false,
        showConfirmButton: false,
        width: 'auto',
        background: '#ffffff',
        backdrop: 'rgba(255, 255, 255, 0.6)',
        customClass: { popup: 'rounded-2xl shadow-sm border border-gray-100' }
    });
}

document.getElementById('filter_jenis_hewan')?.addEventListener('change', function() {
    const kategoriSelect = document.getElementById('filter_kategori');
    if (!kategoriSelect) return;
    if(this.value === 'kambing' || this.value === 'domba') {
        kategoriSelect.value = '';
        kategoriSelect.disabled = true;
        kategoriSelect.classList.add('opacity-50', 'cursor-not-allowed');
    } else {
        kategoriSelect.disabled = false;
        kategoriSelect.classList.remove('opacity-50', 'cursor-not-allowed');
    }
});

document.addEventListener('DOMContentLoaded', function() {
    const filterJenis = document.getElementById('filter_jenis_hewan');
    if (filterJenis) filterJenis.dispatchEvent(new Event('change'));
});

document.getElementById('filter-form')?.addEventListener('change', function(e) {
    if (e.target.id === 'filter_jenis_hewan') {
        // Biarkan listener sebelumnya memproses disabled terlebih dahulu
        // lalu form submit
        setTimeout(() => submitFilterForm.call(this), 50);
        return;
    }
    submitFilterForm.call(this);
});

function submitFilterForm() {
    const url = new URL(this.action);
    const formData = new FormData(this);
    for(let [key, val] of formData.entries()) {
        if(val) url.searchParams.append(key, val);
    }
    
    const container = document.getElementById('table-container');
    container.style.opacity = '0.5';
    container.style.pointerEvents = 'none';
    
    fetch(url, { headers: { 'X-Requested-With': 'XMLHttpRequest' } })
        .then(r => r.text())
        .then(html => {
            const doc = new DOMParser().parseFromString(html, 'text/html');
            container.innerHTML = doc.getElementById('table-container').innerHTML;
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
            window.history.pushState({}, '', url);
        })
        .catch(() => window.location.href = url);
}
</script>
@endpush
@endsection
@extends('layouts.admin')

@section('title', 'Daftar Hewan Kurban')

@section('content')
<div class="p-6">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Daftar Hewan Kurban</h1>
        <a href="{{ route('admin.hewan-kurban.create') }}" 
           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <i class="fas fa-plus mr-2"></i> Tambah Hewan
        </a>
    </div>

    <!-- Kategori Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
        <!-- Prime Class -->
        <div class="bg-blue-600 text-white rounded-lg shadow-sm">
            <div class="p-6">
                <h5 class="text-xl font-semibold mb-2">Prime Class</h5>
                <p class="space-y-1">
                    <span class="block">Range: Rp 0 - Rp 25.000.000</span>
                    <span class="block">Total: {{ $totalPerKategori['prime'] }} ekor</span>
                </p>
            </div>
        </div>

        <!-- Big Boss Class -->
        <div class="bg-green-600 text-white rounded-lg shadow-sm">
            <div class="p-6">
                <h5 class="text-xl font-semibold mb-2">Big Boss Class</h5>
                <p class="space-y-1">
                    <span class="block">Range: Rp 25.000.001 - Rp 50.000.000</span>
                    <span class="block">Total: {{ $totalPerKategori['bigboss'] }} ekor</span>
                </p>
            </div>
        </div>

        <!-- Sultan Class -->
        <div class="bg-yellow-500 text-white rounded-lg shadow-sm">
            <div class="p-6">
                <h5 class="text-xl font-semibold mb-2">Sultan Class</h5>
                <p class="space-y-1">
                    <span class="block">Range: > Rp 50.000.000</span>
                    <span class="block">Total: {{ $totalPerKategori['sultan'] }} ekor</span>
                </p>
            </div>
        </div>
    </div>

    <!-- Filter -->
    <div class="mb-6">
        <form action="{{ route('admin.hewan-kurban.index') }}" method="GET" class="flex gap-3">
            <select name="kategori" 
                    class="rounded-lg border-gray-300 focus:border-blue-500 focus:ring-blue-500">
                <option value="">Semua Kategori</option>
                <option value="prime" {{ request('kategori') == 'prime' ? 'selected' : '' }}>Prime Class</option>
                <option value="bigboss" {{ request('kategori') == 'bigboss' ? 'selected' : '' }}>Big Boss Class</option>
                <option value="sultan" {{ request('kategori') == 'sultan' ? 'selected' : '' }}>Sultan Class</option>
            </select>
            <button type="submit" 
                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                Filter
            </button>
        </form>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead>
                    <tr class="bg-gray-50">
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Foto</th>
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sapi</th>
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Informasi</th>
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                        <th scope="col" class="px-4 py-4 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th scope="col" class="px-4 py-4 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($hewanKurban as $hewan)
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loop->iteration }}
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap">
                            @if($hewan->photos->isNotEmpty())
                                <div class="relative group">
                                    <img src="{{ $hewan->photos->first()->url }}" 
                                         alt="Foto {{ $hewan->jenis_sapi }}"
                                         class="h-16 w-16 rounded-lg object-cover ring-2 ring-gray-100">
                                    <!-- Preview on hover -->
                                    <div class="hidden group-hover:block absolute z-10 -translate-y-full top-0 left-0 p-2 bg-white rounded-lg shadow-lg border border-gray-200">
                                        <img src="{{ $hewan->photos->first()->url }}" 
                                             alt="Preview"
                                             class="w-48 h-48 object-cover rounded-lg">
                                    </div>
                                </div>
                            @else
                                <span class="inline-flex items-center justify-center h-16 w-16 rounded-lg bg-gray-100">
                                    <i class="fas fa-image text-gray-400 text-xl"></i>
                                </span>
                            @endif
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $hewan->jenis_sapi }}</div>
                            <!-- Media badges -->
                            <div class="flex items-center space-x-2 mt-1">
                                @if($hewan->photos->count() > 0)
                                    <span class="inline-flex items-center px-2 py-0.5 bg-blue-50 text-blue-700 text-xs rounded">
                                        <i class="fas fa-images mr-1"></i> {{ $hewan->photos->count() }}
                                    </span>
                                @endif
                                @if($hewan->video_url)
                                    <a href="{{ $hewan->video_url }}" 
                                       target="_blank"
                                       class="inline-flex items-center px-2 py-0.5 bg-cyan-50 text-cyan-700 text-xs rounded hover:bg-cyan-100">
                                        <i class="fas fa-play mr-1"></i> Video
                                    </a>
                                @endif
                            </div>
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="flex flex-col space-y-2">
                                <!-- Kategori -->
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                    {{ $hewan->kategori === 'prime' 
                                        ? 'bg-blue-100 text-blue-800' 
                                        : ($hewan->kategori === 'bigboss' 
                                            ? 'bg-green-100 text-green-800' 
                                            : 'bg-yellow-100 text-yellow-800') }}">
                                    {{ $hewan->kategori_label }}
                                </span>
                                <!-- Info lainnya -->
                                <div class="flex flex-col space-y-1">
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-weight-hanging text-gray-400 mr-1 w-4"></i> {{ $hewan->berat }} kg
                                    </div>
                                    <div class="text-sm text-gray-600">
                                        <i class="fas fa-calendar text-gray-400 mr-1 w-4"></i> {{ $hewan->umur }} tahun
                                    </div>
                                </div>
                            </div>
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">
                                Rp {{ number_format($hewan->harga, 0, ',', '.') }}
                            </div>
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                {{ $hewan->status === 'tersedia' 
                                    ? 'bg-green-100 text-green-800' 
                                    : 'bg-gray-100 text-gray-800' }}">
                                <span class="w-1.5 h-1.5 mr-1.5 rounded-full 
                                    {{ $hewan->status === 'tersedia' ? 'bg-green-400' : 'bg-gray-400' }}">
                                </span>
                                {{ ucfirst($hewan->status) }}
                            </span>
                        </td>
                        
                        <td class="px-4 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex items-center justify-end space-x-2">
                                <a href="{{ route('admin.hewan-kurban.edit', $hewan->id) }}" 
                                   class="text-yellow-600 hover:text-yellow-900 transition-colors">
                                    <span class="bg-yellow-50 p-1.5 rounded hover:bg-yellow-100">
                                        <i class="fas fa-edit"></i>
                                    </span>
                                </a>
                                
                                <form action="{{ route('admin.hewan-kurban.destroy', $hewan->id) }}" 
                                      method="POST" 
                                      class="inline-block"
                                      onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900 transition-colors">
                                        <span class="bg-red-50 p-1.5 rounded hover:bg-red-100">
                                            <i class="fas fa-trash"></i>
                                        </span>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center">
                            <div class="flex flex-col items-center justify-center text-gray-500">
                                <i class="fas fa-inbox text-4xl mb-3"></i>
                                <span class="text-lg">Tidak ada data hewan kurban</span>
                                <p class="text-sm mt-1">Silakan tambah data baru</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($hewanKurban->hasPages())
            <div class="px-4 py-3 border-t border-gray-200 bg-gray-50">
                {{ $hewanKurban->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
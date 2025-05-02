@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-semibold text-gray-800">Dashboard</h1>
        <div class="flex gap-2">
            <button class="flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                <i class="fas fa-download text-sm mr-2"></i>
                Download Laporan
            </button>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <!-- Total Hewan Kurban -->
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-blue-600 text-white rounded-lg">
                <i class="fas fa-cow"></i>
            </div>
            <div class="mt-4">
                <h6 class="text-gray-500 text-sm mb-1">Total Hewan Kurban</h6>
                <h2 class="text-2xl font-bold">{{ $totalHewan }}</h2>
            </div>
        </div>

        <!-- Hewan Tersedia -->
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-green-600 text-white rounded-lg">
                <i class="fas fa-check-circle"></i>
            </div>
            <div class="mt-4">
                <h6 class="text-gray-500 text-sm mb-1">Hewan Tersedia</h6>
                <h2 class="text-2xl font-bold">{{ $totalTersedia }}</h2>
            </div>
        </div>

        <!-- Hewan Terjual -->
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-cyan-600 text-white rounded-lg">
                <i class="fas fa-shopping-cart"></i>
            </div>
            <div class="mt-4">
                <h6 class="text-gray-500 text-sm mb-1">Hewan Terjual</h6>
                <h2 class="text-2xl font-bold">{{ $totalTerjual }}</h2>
            </div>
        </div>

        <!-- Total Pendapatan -->
        <div class="bg-white rounded-lg p-6 shadow-sm hover:shadow-md transition-shadow">
            <div class="inline-flex items-center justify-center w-12 h-12 bg-yellow-500 text-white rounded-lg">
                <i class="fas fa-money-bill-wave"></i>
            </div>
            <div class="mt-4">
                <h6 class="text-gray-500 text-sm mb-1">Total Pendapatan</h6>
                <h2 class="text-2xl font-bold">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</h2>
            </div>
        </div>
    </div>

    <!-- Tabel Transaksi -->
    <div class="bg-white rounded-lg shadow-sm">
        <div class="px-6 py-4 border-b border-gray-200">
            <h5 class="font-semibold text-gray-800">Transaksi Terbaru</h5>
        </div>
        <div class="p-6">
            <div class="overflow-x-auto">
                <table class="w-full min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis Sapi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Harga</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($recentTransactions ?? [] as $transaction)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $loop->iteration }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->jenis_sapi }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                    {{ $transaction->status === 'tersedia' 
                                        ? 'bg-green-100 text-green-800' 
                                        : 'bg-blue-100 text-blue-800' }}">
                                    {{ ucfirst($transaction->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $transaction->created_at->format('d M Y') }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">Tidak ada data transaksi</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
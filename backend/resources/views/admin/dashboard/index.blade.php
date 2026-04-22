@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-gray-900">Dashboard</h1>
        <button class="btn-primary text-xs">
            <i class="fas fa-download mr-1.5 text-[11px]"></i> Download Laporan
        </button>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-green-50 flex items-center justify-center text-green-600">
                    <i class="fas fa-cow text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Total Hewan</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalHewan }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-emerald-50 flex items-center justify-center text-emerald-600">
                    <i class="fas fa-check-circle text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Tersedia</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalTersedia }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-sky-50 flex items-center justify-center text-sky-600">
                    <i class="fas fa-shopping-cart text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Terjual</p>
                    <p class="text-xl font-bold text-gray-900">{{ $totalTerjual }}</p>
                </div>
            </div>
        </div>
        <div class="bg-white rounded-lg border border-gray-100 p-4">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-lg bg-amber-50 flex items-center justify-center text-amber-600">
                    <i class="fas fa-money-bill-wave text-sm"></i>
                </div>
                <div>
                    <p class="text-xs text-gray-400 font-medium uppercase tracking-wide">Pendapatan</p>
                    <p class="text-lg font-bold text-gray-900">Rp {{ number_format($totalPendapatan ?? 0, 0, ',', '.') }}</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Transactions -->
    <div class="bg-white rounded-lg border border-gray-100">
        <div class="px-5 py-3.5 border-b border-gray-50">
            <h2 class="text-sm font-semibold text-gray-800">Transaksi Terbaru</h2>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full min-w-[560px] text-sm">
                <thead>
                    <tr class="border-b border-gray-50">
                        <th class="px-5 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">No</th>
                        <th class="px-5 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Jenis</th>
                        <th class="px-5 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Harga</th>
                        <th class="px-5 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Status</th>
                        <th class="px-5 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Tanggal</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($recentTransactions ?? [] as $transaction)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-5 py-3 text-gray-400">{{ $loop->iteration }}</td>
                        <td class="px-5 py-3 font-medium text-gray-700">{{ $transaction->jenis_sapi }}</td>
                        <td class="px-5 py-3 font-medium text-gray-800">Rp {{ number_format($transaction->harga, 0, ',', '.') }}</td>
                        <td class="px-5 py-3">
                            <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium
                                {{ $transaction->status === 'tersedia'
                                    ? 'bg-green-50 text-green-700'
                                    : 'bg-sky-50 text-sky-700' }}">
                                <span class="w-1 h-1 rounded-full {{ $transaction->status === 'tersedia' ? 'bg-green-500' : 'bg-sky-500' }}"></span>
                                {{ ucfirst($transaction->status) }}
                            </span>
                        </td>
                        <td class="px-5 py-3 text-gray-400">{{ $transaction->created_at->format('d M Y') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center text-gray-400 text-sm">
                            <i class="fas fa-inbox text-2xl text-gray-200 mb-2 block"></i>
                            Belum ada transaksi
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
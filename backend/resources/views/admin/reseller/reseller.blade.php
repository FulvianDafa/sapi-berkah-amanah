@extends('layouts.admin')

@section('title', 'Daftar Reseller')

@section('content')
<div class="space-y-5">

    <!-- Header -->
    <div class="flex items-center justify-between">
        <h1 class="text-lg font-semibold text-gray-900">Daftar Reseller</h1>
        <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-700">
            <i class="fas fa-sync-alt text-[10px]"></i> Synced
        </span>
    </div>

    <!-- Table -->
    <div class="bg-white rounded-lg border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Timestamp</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Nama Lengkap</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">WhatsApp</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Profesi</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Alamat</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Rekening</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Bank</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">No. Rek</th>
                        <th class="px-4 py-2.5 text-left text-xs font-medium uppercase tracking-wider text-gray-400">Atas Nama</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @forelse($resellers as $reseller)
                    <tr class="hover:bg-gray-50/50 transition-colors">
                        <td class="px-4 py-3 text-xs text-gray-400 whitespace-nowrap">{{ $reseller['Timestamp'] ?? '-' }}</td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <div class="w-7 h-7 rounded-full bg-green-600 flex items-center justify-center text-white text-[10px] font-bold shrink-0">
                                    {{ strtoupper(substr($reseller['Nama Lengkap'] ?? 'R', 0, 1)) }}
                                </div>
                                <span class="text-sm font-medium text-gray-800">{{ $reseller['Nama Lengkap'] ?? '-' }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-3 whitespace-nowrap">
                            @if($reseller['Nomor WhatsApp'] ?? false)
                                @php
                                    $rawNumber = preg_replace('/[^0-9]/', '', $reseller['Nomor WhatsApp']);
                                    // Pastikan nomor diawali 62
                                    if (str_starts_with($rawNumber, '0')) {
                                        $waNumber = '62' . substr($rawNumber, 1);
                                    } elseif (!str_starts_with($rawNumber, '62')) {
                                        $waNumber = '62' . $rawNumber;
                                    } else {
                                        $waNumber = $rawNumber;
                                    }
                                @endphp
                                <a href="https://wa.me/{{ $waNumber }}" target="_blank"
                                   class="inline-flex items-center gap-1 text-green-600 hover:text-green-700 text-sm font-medium transition-colors">
                                    <i class="fab fa-whatsapp"></i>
                                    {{ $waNumber }}
                                </a>
                            @else
                                <span class="text-gray-300">-</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $reseller['Profesi'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 max-w-[180px] truncate" title="{{ $reseller['Alamat'] ?? '' }}">
                            {{ $reseller['Alamat'] ?? '-' }}
                        </td>
                        <td class="px-4 py-3">
                            @if(($reseller['Punya Rekening'] ?? '') === 'Ya')
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-green-50 text-green-600">Ya</span>
                            @else
                                <span class="inline-block px-2 py-0.5 rounded text-xs font-medium bg-gray-50 text-gray-500">Tidak</span>
                            @endif
                        </td>
                        <td class="px-4 py-3 text-gray-600">{{ $reseller['Nama Bank'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600 font-mono text-xs">{{ $reseller['Nomor Rekening'] ?? '-' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $reseller['Atas Nama'] ?? '-' }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="9" class="px-4 py-12 text-center text-gray-400 text-sm">
                            <i class="fas fa-users text-2xl text-gray-200 mb-2 block"></i>
                            Belum ada data reseller
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

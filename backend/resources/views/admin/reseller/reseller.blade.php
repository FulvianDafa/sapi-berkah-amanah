@extends('layouts.admin') {{-- atau layouts/admin, sesuaikan --}}

@section('content')
<div class="container mx-auto">
    <h1 class="text-2xl font-bold mb-4">Daftar Reseller</h1>
    <div class="overflow-x-auto bg-white rounded shadow">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-slate-800 text-white">
                <tr>
                    <th class="px-4 py-2">Timestamp</th>
                    <th class="px-4 py-2">Nama Lengkap</th>
                    <th class="px-4 py-2">Nomor WhatsApp</th>
                    <th class="px-4 py-2">Profesi</th>
                    <th class="px-4 py-2">Alamat</th>
                    <th class="px-4 py-2">Punya Rekening</th>
                    <th class="px-4 py-2">Nama Bank</th>
                    <th class="px-4 py-2">Nomor Rekening</th>
                    <th class="px-4 py-2">Atas Nama</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($resellers as $reseller)
                <tr>
                    <td class="px-4 py-2">{{ $reseller['Timestamp'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Nama Lengkap'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Nomor WhatsApp'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Profesi'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Alamat'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Punya Rekening'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Nama Bank'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Nomor Rekening'] ?? '-' }}</td>
                    <td class="px-4 py-2">{{ $reseller['Atas Nama'] ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center py-4">Belum ada data reseller.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection

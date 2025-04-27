<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Hewan Kurban</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Daftar Hewan Kurban</h1>

        <a href="{{ route('admin.hewan.create') }}" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded mb-4 inline-block">+ Tambah Hewan</a>

        <table class="min-w-full bg-white border">
            <thead class="bg-gray-200">
                <tr>
                    <th class="py-2 px-4 border">Nama</th>
                    <th class="py-2 px-4 border">Jenis</th>
                    <th class="py-2 px-4 border">Harga</th>
                    <th class="py-2 px-4 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($hewans as $hewan)
                <tr>
                    <td class="py-2 px-4 border">{{ $hewan->nama }}</td>
                    <td class="py-2 px-4 border">{{ $hewan->jenis }}</td>
                    <td class="py-2 px-4 border">Rp{{ number_format($hewan->harga, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border flex gap-2">
                        <a href="{{ route('admin.hewan.edit', $hewan->id) }}" class="bg-yellow-400 text-white px-2 py-1 rounded">Edit</a>
                        <form action="{{ route('admin.hewan.destroy', $hewan->id) }}" method="POST" onsubmit="return confirm('Yakin mau hapus?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-2 py-1 rounded">Hapus</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>

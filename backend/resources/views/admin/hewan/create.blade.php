<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Hewan Kurban</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Tambah Hewan Kurban</h1>

        <form action="{{ route('admin.hewan.store') }}" method="POST" class="space-y-4">
            @csrf

            <div>
                <label>Nama</label>
                <input type="text" name="nama" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Jenis</label>
                <input type="text" name="jenis" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Foto (URL)</label>
                <input type="url" name="foto" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded px-3 py-2"></textarea>
            </div>

            <div>
                <label>Harga</label>
                <input type="number" name="harga" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-green-500 hover:bg-green-600 text-white px-4 py-2 rounded">Simpan</button>
        </form>

    </div>

</body>
</html>

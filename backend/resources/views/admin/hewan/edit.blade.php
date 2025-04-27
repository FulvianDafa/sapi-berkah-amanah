<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Hewan Kurban</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-6">Edit Hewan Kurban</h1>

        <form action="{{ route('admin.hewan.update', $hewan->id) }}" method="POST" class="space-y-4">
            @csrf
            @method('PUT')

            <div>
                <label>Nama</label>
                <input type="text" name="nama" value="{{ $hewan->nama }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Jenis</label>
                <input type="text" name="jenis" value="{{ $hewan->jenis }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Foto (URL)</label>
                <input type="url" name="foto" value="{{ $hewan->foto }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label>Deskripsi</label>
                <textarea name="deskripsi" class="w-full border rounded px-3 py-2">{{ $hewan->deskripsi }}</textarea>
            </div>

            <div>
                <label>Harga</label>
                <input type="number" name="harga" value="{{ $hewan->harga }}" class="w-full border rounded px-3 py-2" required>
            </div>

            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white px-4 py-2 rounded">Update</button>
        </form>

    </div>

</body>
</html>

<?php

namespace App\Http\Controllers;

use App\Models\HewanKurban;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HewanKurbanController extends Controller
{
    public function index()
    {
        return response()->json(HewanKurban::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'deskripsi' => 'nullable|string',
            'berat' => 'required|integer',
            'harga' => 'required|numeric',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            $validated['gambar'] = $request->file('gambar')->store('gambar-hewan', 'public');
        }

        $hewanKurban = HewanKurban::create($validated);

        return response()->json($hewanKurban, 201);
    }

    public function show(HewanKurban $hewanKurban)
    {
        return response()->json($hewanKurban);
    }

    public function update(Request $request, HewanKurban $hewanKurban)
    {
        $validated = $request->validate([
            'nama' => 'sometimes|required|string|max:255',
            'deskripsi' => 'nullable|string',
            'berat' => 'sometimes|required|integer',
            'harga' => 'sometimes|required|numeric',
            'gambar' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('gambar')) {
            if ($hewanKurban->gambar) {
                Storage::disk('public')->delete($hewanKurban->gambar);
            }
            $validated['gambar'] = $request->file('gambar')->store('gambar-hewan', 'public');
        }

        $hewanKurban->update($validated);

        return response()->json($hewanKurban);
    }

    public function destroy(HewanKurban $hewanKurban)
    {
        if ($hewanKurban->gambar) {
            Storage::disk('public')->delete($hewanKurban->gambar);
        }
        $hewanKurban->delete();

        return response()->json(null, 204);
    }
}

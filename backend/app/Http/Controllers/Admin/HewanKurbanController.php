<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HewanKurban;
use Illuminate\Http\Request;

class HewanKurbanController extends Controller
{
    public function index()
    {
        $hewans = HewanKurban::all();
        return view('admin.hewan.index', compact('hewans'));
    }

    public function create()
    {
        return view('admin.hewan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'foto' => 'required|url',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
        ]);

        HewanKurban::create($request->all());

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan kurban berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $hewan = HewanKurban::findOrFail($id);
        return view('admin.hewan.edit', compact('hewan'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required',
            'jenis' => 'required',
            'foto' => 'required|url',
            'deskripsi' => 'nullable',
            'harga' => 'required|numeric',
        ]);

        $hewan = HewanKurban::findOrFail($id);
        $hewan->update($request->all());

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan kurban berhasil diupdate.');
    }

    public function destroy($id)
    {
        $hewan = HewanKurban::findOrFail($id);
        $hewan->delete();

        return redirect()->route('admin.hewan.index')->with('success', 'Hewan kurban berhasil dihapus.');
    }
}

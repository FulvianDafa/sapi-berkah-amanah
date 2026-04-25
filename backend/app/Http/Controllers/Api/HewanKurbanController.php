<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\HewanKurban;
use App\Services\HewanKurbanService;

class HewanKurbanController extends Controller
{
    protected $hewanKurbanService;

    public function __construct(HewanKurbanService $hewanKurbanService)
    {
        $this->hewanKurbanService = $hewanKurbanService;
    }

    public function index()
    {
        try {
            $hewanKurban = $this->hewanKurbanService->getKatalog()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'jenis_hewan' => $item->jenis_hewan,
                    'nama' => $item->nama,
                    'jenis_sapi' => ucfirst($item->jenis_hewan) . ' ' . $item->nama, // TODO: Hapus baris ini nanti
                    'kategori' => $item->kategori,
                    'berat' => $item->berat,
                    'berat_sapi' => $item->berat, // TODO: Hapus baris ini nanti
                    'umur' => $item->umur,
                    'umur_sapi' => $item->umur, // TODO: Hapus baris ini nanti
                    'harga' => $item->harga,
                    'photos' => $item->photos->map(function ($photo) {
                        return $photo->url;
                    })->toArray()
                ];
            });

            return response()->json([
                'success' => true,
                'data' => $hewanKurban
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $item = HewanKurban::with('photos')->findOrFail($id);

            return response()->json([
                'success' => true,
                'data' => [
                    'id' => $item->id,
                    'jenis_hewan' => $item->jenis_hewan,
                    'nama' => $item->nama,
                    'jenis_sapi' => ucfirst($item->jenis_hewan) . ' ' . $item->nama, // TODO: Hapus baris ini nanti
                    'kategori' => $item->kategori,
                    'berat' => $item->berat,
                    'berat_sapi' => $item->berat, // TODO: Hapus baris ini nanti
                    'umur' => $item->umur,
                    'umur_sapi' => $item->umur, // TODO: Hapus baris ini nanti
                    'harga' => $item->harga,
                    'deskripsi' => $item->deskripsi,
                    'photos' => $item->photos->map(function ($photo) {
                        return $photo->url;
                    })->toArray(),
                    'video_url' => $item->video_url,
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 404);
        }
    }
}

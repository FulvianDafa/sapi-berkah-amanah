<?php

namespace App\Http\Controllers;

use App\Models\HewanKurban;
use App\Services\MediaUploadService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HewanKurbanController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    public function index()
    {
        try {
            $hewanKurban = HewanKurban::with('photos')->get();
            
            return response()->json([
                'success' => true,
                'data' => $hewanKurban,
                'message' => $hewanKurban->isEmpty() ? 'Tidak ada data' : 'Data berhasil diambil'
            ]);
            
        } catch (\Exception $e) {
            Log::error('Error in HewanKurbanController@index: ' . $e->getMessage());
            Log::error($e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function show($id)
    {
        $hewanKurban = HewanKurban::with('photos')->findOrFail($id);
        return response()->json($hewanKurban);
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_sapi' => 'required|string',
            'umur' => 'required|integer',
            'berat' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'required|image|max:5000',
            'video' => 'nullable|mimes:mp4,mov|max:100000'
        ]);

        DB::beginTransaction();
        try {
            // Upload video jika ada
            $videoUrl = null;
            if ($request->hasFile('video')) {
                $videoResult = $this->mediaUploadService->uploadVideo($request->file('video'));
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                $videoUrl = $videoResult['url'];
            }

            // Simpan data hewan kurban
            $hewanKurban = HewanKurban::create([
                'jenis_sapi' => $request->jenis_sapi,
                'umur' => $request->umur,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'video_url' => $videoUrl
            ]);

            // Upload dan simpan foto-foto
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $result = $this->mediaUploadService->uploadImage($photo);
                    if (!$result['success']) {
                        throw new \Exception($result['message']);
                    }

                    $hewanKurban->photos()->create([
                        'public_id' => $result['public_id'],
                        'url' => $result['url'],
                        'order' => $index
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil disimpan',
                'data' => $hewanKurban->load('photos')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menyimpan data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_sapi' => 'required|string',
            'umur' => 'required|integer',
            'berat' => 'required|integer',
            'harga' => 'required|numeric',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'nullable|image|max:5000',
            'video' => 'nullable|mimes:mp4,mov|max:100000'
        ]);

        DB::beginTransaction();
        try {
            $hewanKurban = HewanKurban::findOrFail($id);

            // Update video jika ada video baru
            if ($request->hasFile('video')) {
                // Hapus video lama jika ada
                if ($hewanKurban->video_url) {
                    // Implement delete old video if needed
                }

                $videoResult = $this->mediaUploadService->uploadVideo($request->file('video'));
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                $hewanKurban->video_url = $videoResult['url'];
            }

            // Update data dasar
            $hewanKurban->update([
                'jenis_sapi' => $request->jenis_sapi,
                'umur' => $request->umur,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi
            ]);

            // Upload foto baru jika ada
            if ($request->hasFile('photos')) {
                // Hapus foto lama jika diminta
                if ($request->boolean('replace_photos')) {
                    foreach ($hewanKurban->photos as $photo) {
                        $this->mediaUploadService->delete($photo->public_id);
                    }
                    $hewanKurban->photos()->delete();
                }

                // Upload foto baru
                foreach ($request->file('photos') as $index => $photo) {
                    $result = $this->mediaUploadService->uploadImage($photo);
                    if (!$result['success']) {
                        throw new \Exception($result['message']);
                    }

                    $hewanKurban->photos()->create([
                        'public_id' => $result['public_id'],
                        'url' => $result['url'],
                        'order' => $index
                    ]);
                }
            }

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil diupdate',
                'data' => $hewanKurban->load('photos')
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal mengupdate data: ' . $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $hewanKurban = HewanKurban::with('photos')->findOrFail($id);

            // Hapus foto-foto dari Cloudinary
            foreach ($hewanKurban->photos as $photo) {
                $this->mediaUploadService->delete($photo->public_id);
            }

            // Hapus data dari database
            $hewanKurban->photos()->delete();
            $hewanKurban->delete();

            DB::commit();
            return response()->json([
                'message' => 'Data berhasil dihapus'
            ]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal menghapus data: ' . $e->getMessage()
            ], 500);
        }
    }
}
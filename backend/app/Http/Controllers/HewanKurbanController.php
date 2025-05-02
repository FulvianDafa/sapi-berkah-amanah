<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HewanKurban;
use App\Services\MediaUploadService;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HewanKurbanController extends Controller
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
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
                if ($hewanKurban->video_public_id) {
                    $this->mediaUploadService->delete($hewanKurban->video_public_id);
                }

                $videoResult = $this->mediaUploadService->uploadVideo($request->file('video'));
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                
                $hewanKurban->video_url = $videoResult['url'];
                $hewanKurban->video_public_id = $videoResult['public_id'];
            }

            // Update data dasar
            $hewanKurban->update([
                'jenis_sapi' => $request->jenis_sapi,
                'umur' => $request->umur,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'deskripsi' => $request->deskripsi,
                'status' => $request->status ?? $hewanKurban->status
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
            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data berhasil diperbarui');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating hewan kurban: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }
}
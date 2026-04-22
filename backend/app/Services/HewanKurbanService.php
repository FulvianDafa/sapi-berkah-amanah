<?php

namespace App\Services;

use App\Models\HewanKurban;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HewanKurbanService
{
    protected $mediaUploadService;

    public function __construct(MediaUploadService $mediaUploadService)
    {
        $this->mediaUploadService = $mediaUploadService;
    }

    public function getKatalog()
    {
        return HewanKurban::with('photos')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function createHewanKurban(array $data, array $photos = null, $video = null)
    {
        DB::beginTransaction();
        try {
            // Upload video
            $videoUrl = null;
            $videoPublicId = null;
            if ($video) {
                $videoResult = $this->mediaUploadService->uploadVideo($video);
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                $videoUrl = $videoResult['url'];
                $videoPublicId = $videoResult['public_id'];
            }

            // Simpan data
            $hewanKurban = HewanKurban::create([
                'jenis_sapi' => $data['jenis_sapi'],
                'umur' => $data['umur'],
                'berat' => $data['berat'],
                'harga' => $data['harga'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'video_url' => $videoUrl,
                'video_public_id' => $videoPublicId,
                'status' => 'tersedia'
            ]);

            // Upload dan simpan foto
            $uploadedPhotos = [];
            if ($photos) {
                foreach ($photos as $index => $photo) {
                    try {
                        $result = $this->mediaUploadService->uploadImage($photo);
                        if (!$result['success']) {
                            throw new \Exception($result['message']);
                        }
                        
                        $uploadedPhotos[] = [
                            'public_id' => $result['public_id'],
                            'url' => $result['url'],
                            'order' => $index
                        ];
                    } catch (\Exception $e) {
                        foreach ($uploadedPhotos as $uploadedPhoto) {
                            $this->mediaUploadService->delete($uploadedPhoto['public_id']);
                        }
                        throw $e;
                    }
                }

                foreach ($uploadedPhotos as $photo) {
                    $hewanKurban->photos()->create($photo);
                }
            }

            DB::commit();
            return $hewanKurban;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in HewanKurbanService@createHewanKurban: ' . $e->getMessage());
            throw $e;
        }
    }

    public function updateHewanKurban(HewanKurban $hewanKurban, array $data, array $photos = null, $video = null)
    {
        DB::beginTransaction();
        try {
            // Update video
            if ($video) {
                if ($hewanKurban->video_public_id) {
                    $this->mediaUploadService->delete($hewanKurban->video_public_id);
                }
                
                $videoResult = $this->mediaUploadService->uploadVideo($video);
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                
                $videoUrl = $videoResult['url'];
                $videoPublicId = $videoResult['public_id'];
            } else {
                $videoUrl = $hewanKurban->video_url;
                $videoPublicId = $hewanKurban->video_public_id;
            }

            $hewanKurban->update([
                'jenis_sapi' => $data['jenis_sapi'],
                'umur' => $data['umur'],
                'berat' => $data['berat'],
                'harga' => $data['harga'],
                'deskripsi' => $data['deskripsi'] ?? null,
                'video_url' => $videoUrl,
                'video_public_id' => $videoPublicId
            ]);

            // Upload foto baru
            if ($photos) {
                $currentPhotoCount = $hewanKurban->photos->count();
                foreach ($photos as $index => $photo) {
                    $result = $this->mediaUploadService->uploadImage($photo);
                    if (!$result['success']) {
                        throw new \Exception($result['message']);
                    }
                    
                    $hewanKurban->photos()->create([
                        'public_id' => $result['public_id'],
                        'url' => $result['url'],
                        'order' => $index + $currentPhotoCount
                    ]);
                }
            }

            DB::commit();
            return $hewanKurban;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in HewanKurbanService@updateHewanKurban: ' . $e->getMessage());
            throw $e;
        }
    }

    public function deleteHewanKurban(HewanKurban $hewanKurban)
    {
        DB::beginTransaction();
        try {
            // Hapus foto-foto
            foreach ($hewanKurban->photos as $photo) {
                $this->mediaUploadService->delete($photo->public_id);
            }

            // Hapus video jika ada
            if ($hewanKurban->video_public_id) {
                $this->mediaUploadService->delete($hewanKurban->video_public_id);
            }

            $hewanKurban->photos()->delete();
            $hewanKurban->delete();

            DB::commit();
            return true;
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error in HewanKurbanService@deleteHewanKurban: ' . $e->getMessage());
            throw $e;
        }
    }
}

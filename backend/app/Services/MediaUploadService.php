<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Cloudinary\Api\Upload\UploadApi;

class MediaUploadService
{
    protected $uploadApi;

    public function __construct()
    {
        $this->uploadApi = new UploadApi();
    }

    public function uploadImage($file)
    {
        try {
            $result = $this->uploadApi->upload($file->getRealPath(), [
                'folder' => 'hewan-kurban/photos',
                'transformation' => [
                    'quality' => 'auto',
                    'width' => 1200,
                    'height' => 1200,
                    'crop' => 'limit'
                ]
            ]);

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'url' => $result['secure_url']
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Upload gagal: ' . $e->getMessage()
            ];
        }
    }

    public function uploadVideo($file)
    {
        try {
            $result = $this->uploadApi->upload($file->getRealPath(), [
                'folder' => 'hewan-kurban/videos',
                'resource_type' => 'video',
                'transformation' => [
                    'quality' => 'auto'
                ]
            ]);

            return [
                'success' => true,
                'public_id' => $result['public_id'],
                'url' => $result['secure_url']
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary upload error: ' . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Upload gagal: ' . $e->getMessage()
            ];
        }
    }

    public function delete($publicId)
    {
        try {
            $this->uploadApi->destroy($publicId);
            return true;
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error: ' . $e->getMessage());
            return false;
        }
    }
}
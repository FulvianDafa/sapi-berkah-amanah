<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Cloudinary\Api\Upload\UploadApi;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class MediaUploadService
{
    protected $uploadApi;
    protected $cloudinary;

    public function __construct()
    {
        $this->uploadApi = new UploadApi();
        // Initialize Cloudinary with configuration
        $this->cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => config('cloudinary.cloud_name'),
                'api_key'    => config('cloudinary.api_key'),
                'api_secret' => config('cloudinary.api_secret'),
                'secure'     => config('cloudinary.secure', true)
            ]
        ]);
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
            Log::info('Attempting to delete from Cloudinary:', [
                'public_id' => $publicId,
                'config' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'has_secret' => !empty(config('cloudinary.api_secret'))
                ]
            ]);
            
            $result = $this->cloudinary->uploadApi()->destroy($publicId, [
                'resource_type' => 'image',
                'invalidate' => true
            ]);
            
            Log::info('Cloudinary delete result:', ['result' => $result]);

            return [
                'success' => $result['result'] === 'ok',
                'result' => $result
            ];
        } catch (\Exception $e) {
            Log::error('Cloudinary delete error:', [
                'public_id' => $publicId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return [
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
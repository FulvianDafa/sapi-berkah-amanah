<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HewanKurban;
use App\Models\HewanKurbanPhoto as HewanKurbanPhoto;
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

    public function index(Request $request)
    {
        try {
            $query = HewanKurban::with('photos');

            // Filter berdasarkan kategori jika ada
            if ($request->has('kategori')) {
                $query->kategori($request->kategori);
            }

            $hewanKurban = $query->latest()->paginate(10);
            $totalPerKategori = [
                'prime' => HewanKurban::kategori('prime')->count(),
                'bigboss' => HewanKurban::kategori('bigboss')->count(),
                'sultan' => HewanKurban::kategori('sultan')->count(),
            ];

            return view('admin.hewan-kurban.index', compact('hewanKurban', 'totalPerKategori'));
        } catch (\Exception $e) {
            Log::error('Error in HewanKurbanController@index: ' . $e->getMessage());
            return back()->with('error', 'Gagal mengambil data: ' . $e->getMessage());
        }
    }

    public function create()
    {
        return view('admin.hewan-kurban.form');
    }

    public function store(Request $request)
    {
        $request->validate([
            'jenis_sapi' => 'required|string|max:255',
            'umur' => 'required|numeric|min:0.1',
            'berat' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'photos' => 'required_without:photo_ids|array|min:1|max:5',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'video' => 'nullable|mimes:mp4,mov|max:102400'
        ]);

        DB::beginTransaction();
        try {
            // Tentukan kategori berdasarkan harga
            $kategori = $this->determineKategori($request->berat);

            // Upload video jika ada
            $videoUrl = null;
            $videoPublicId = null;
            if ($request->hasFile('video')) {
                $videoResult = $this->mediaUploadService->uploadVideo($request->file('video'));
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                $videoUrl = $videoResult['url'];
                $videoPublicId = $videoResult['public_id'];
            }

            // Simpan data hewan kurban
            $hewanKurban = HewanKurban::create([
                'jenis_sapi' => $request->jenis_sapi,
                'umur' => $request->umur,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'kategori' => $kategori, // Kategori otomatis
                'deskripsi' => $request->deskripsi,
                'video_url' => $videoUrl,
                'video_public_id' => $videoPublicId,
                'status' => 'tersedia'
            ]);

            // Upload dan simpan foto-foto
            $uploadedPhotos = [];
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
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
                        // Jika ada error saat upload, hapus foto-foto yang sudah terupload
                        foreach ($uploadedPhotos as $uploadedPhoto) {
                            $this->mediaUploadService->delete($uploadedPhoto['public_id']);
                        }
                        throw $e;
                    }
                }

                // Simpan semua foto ke database
                foreach ($uploadedPhotos as $photo) {
                    $hewanKurban->photos()->create($photo);
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data hewan kurban berhasil disimpan');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error saving hewan kurban: ' . $e->getMessage());
            return back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
        }
    }

    // Tambahkan method untuk menentukan kategori
    private function determineKategori($berat)
    {
        if ($berat >= 700) { 
            return 'sultan';
        } elseif ($berat >= 500) { 
            return 'bigboss';
        } else { 
            return 'prime';
        }
    }

    public function edit($id)
    {
        $hewanKurban = HewanKurban::with('photos')->findOrFail($id);
        return view('admin.hewan-kurban.form', compact('hewanKurban'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'jenis_sapi' => 'required|string|max:255',
            'umur' => 'required|numeric|min:0.1',
            'berat' => 'required|integer|min:1',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'video' => 'nullable|mimes:mp4,mov|max:102400'
        ]);

        DB::beginTransaction();
        try {
            $hewanKurban = HewanKurban::findOrFail($id);
            
            // Tentukan kategori berdasarkan harga baru
            $kategori = $this->determineKategori($request->berat);

            // Update video jika ada
            if ($request->hasFile('video')) {
                // Hapus video lama jika ada
                if ($hewanKurban->video_public_id) {
                    $this->mediaUploadService->delete($hewanKurban->video_public_id);
                }
                
                $videoResult = $this->mediaUploadService->uploadVideo($request->file('video'));
                if (!$videoResult['success']) {
                    throw new \Exception($videoResult['message']);
                }
                
                $videoUrl = $videoResult['url'];
                $videoPublicId = $videoResult['public_id'];
            } else {
                $videoUrl = $hewanKurban->video_url;
                $videoPublicId = $hewanKurban->video_public_id;
            }

            // Update data hewan
            $hewanKurban->update([
                'jenis_sapi' => $request->jenis_sapi,
                'umur' => $request->umur,
                'berat' => $request->berat,
                'harga' => $request->harga,
                'kategori' => $kategori, // Kategori otomatis update
                'deskripsi' => $request->deskripsi,
                'video_url' => $videoUrl ?? $hewanKurban->video_url,
                'video_public_id' => $videoPublicId ?? $hewanKurban->video_public_id
            ]);

            // Upload foto baru jika ada
            if ($request->hasFile('photos')) {
                foreach ($request->file('photos') as $index => $photo) {
                    $result = $this->mediaUploadService->uploadImage($photo);
                    if (!$result['success']) {
                        throw new \Exception($result['message']);
                    }
                    
                    $hewanKurban->photos()->create([
                        'public_id' => $result['public_id'],
                        'url' => $result['url'],
                        'order' => $index + $hewanKurban->photos->count()
                    ]);
                }
            }

            DB::commit();
            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
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
            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function deletePhoto($photoId)
    {
        try {
            Log::info('Starting photo deletion process for ID: ' . $photoId);
            
            $photo = HewanKurbanPhoto::findOrFail($photoId);
            Log::info('Found photo:', [
                'photo' => $photo->toArray(),
                'cloudinary_config' => [
                    'cloud_name' => config('cloudinary.cloud_name'),
                    'api_key' => config('cloudinary.api_key'),
                    'has_secret' => !empty(config('cloudinary.api_secret'))
                ]
            ]);

            // Delete from Cloudinary
            $deleteResult = $this->mediaUploadService->delete($photo->public_id);
            Log::info('Cloudinary deletion result:', $deleteResult);

            if (!$deleteResult['success']) {
                throw new \Exception('Failed to delete from Cloudinary: ' . ($deleteResult['error'] ?? 'Unknown error'));
            }

            // If Cloudinary delete successful, delete from database
            $photo->delete();
            Log::info('Photo deleted from database successfully');

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in deletePhoto:', [
                'photo_id' => $photoId,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }

    public function getKatalog()
    {
        try {
            $hewanKurban = HewanKurban::with('photos')
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(function ($item) {
                    return [
                        'id' => $item->id,
                        'jenis_sapi' => $item->jenis_sapi,
                        'kategori' => $item->kategori,
                        'berat_sapi' => $item->berat,
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
                    'jenis_sapi' => $item->jenis_sapi,
                    'kategori' => $item->kategori,
                    'berat_sapi' => $item->berat,
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
<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HewanKurban;
use App\Models\HewanKurbanPhoto;
use App\Services\MediaUploadService;
use App\Services\HewanKurbanService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HewanKurbanController extends Controller
{
    protected $hewanKurbanService;
    protected $mediaUploadService; // Masih dipakai untuk hapus photo spesifik via ajax

    public function __construct(HewanKurbanService $hewanKurbanService, MediaUploadService $mediaUploadService)
    {
        $this->hewanKurbanService = $hewanKurbanService;
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
            'jenis_hewan' => 'required|in:sapi,kambing',
            'nama' => 'required|string|max:255',
            'umur' => 'nullable|numeric|min:0.1',
            'berat' => 'nullable|integer|min:1',
            'kategori' => 'nullable|in:prime,bigboss,sultan',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'photos' => 'required_without:photo_ids|array|min:1|max:5',
            'photos.*' => 'required|image|mimes:jpeg,png,jpg|max:5120',
            'video' => 'nullable|mimes:mp4,mov|max:102400'
        ]);

        try {
            $this->hewanKurbanService->createHewanKurban(
                $request->only(['jenis_hewan', 'nama', 'umur', 'berat', 'kategori', 'harga', 'deskripsi']),
                $request->file('photos'),
                $request->file('video')
            );

            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data hewan kurban berhasil disimpan');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal menyimpan data: ' . $e->getMessage())
                ->withInput();
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
            'jenis_hewan' => 'required|in:sapi,kambing',
            'nama' => 'required|string|max:255',
            'umur' => 'nullable|numeric|min:0.1',
            'berat' => 'nullable|integer|min:1',
            'kategori' => 'nullable|in:prime,bigboss,sultan',
            'harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'photos.*' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'video' => 'nullable|mimes:mp4,mov|max:102400'
        ]);

        try {
            $hewanKurban = HewanKurban::findOrFail($id);
            $this->hewanKurbanService->updateHewanKurban(
                $hewanKurban,
                $request->only(['jenis_hewan', 'nama', 'umur', 'berat', 'kategori', 'harga', 'deskripsi']),
                $request->file('photos'),
                $request->file('video')
            );

            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data berhasil diupdate');
        } catch (\Exception $e) {
            return back()
                ->with('error', 'Gagal mengupdate data: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function destroy($id)
    {
        try {
            $hewanKurban = HewanKurban::findOrFail($id);
            $this->hewanKurbanService->deleteHewanKurban($hewanKurban);

            return redirect()
                ->route('admin.hewan-kurban.index')
                ->with('success', 'Data berhasil dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus data: ' . $e->getMessage());
        }
    }

    public function deletePhoto($photoId)
    {
        try {
            $photo = HewanKurbanPhoto::findOrFail($photoId);
            $deleteResult = $this->mediaUploadService->delete($photo->public_id);

            if (!$deleteResult['success']) {
                throw new \Exception('Failed to delete from Cloudinary: ' . ($deleteResult['error'] ?? 'Unknown error'));
            }

            $photo->delete();

            return response()->json([
                'success' => true,
                'message' => 'Foto berhasil dihapus'
            ]);
        } catch (\Exception $e) {
            Log::error('Error in deletePhoto: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus foto: ' . $e->getMessage()
            ], 500);
        }
    }
}
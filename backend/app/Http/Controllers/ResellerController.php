<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResellerController extends Controller
{
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string',
            'wa' => 'required|string',
            'profesi' => 'required|string',
            'alamat' => 'required|string',
            'punyaRekening' => 'required|string',
            'bank' => 'nullable|string',
            'norek' => 'nullable|string',
            'atasNama' => 'nullable|string',
        ]);

        // Kirim ke Google Apps Script
        $response = Http::withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ])->post('https://script.google.com/macros/s/AKfycbwS2F9Ogkhpdv3QP4m78fNtvFX6kn7Ia5Oo8wUcJJ74GwLavMSwmJlha309wdTULPX5/exec', $validated);

        if ($response->successful()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => $response->body()], 500);
        }
    }
}

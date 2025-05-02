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
        $response = Http::post('https://script.google.com/macros/s/AKfycbzP6ym1ybtYs_7qucriVoS9r5Pp-iqpgBliJVRq-RqOJBLm8-GJHOFNLfDKfK00rmns/exec', $validated);

        if ($response->successful()) {
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'error' => $response->body()], 500);
        }
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class ResellerController extends Controller
{
    public function index()
    {
        // Ganti URL di bawah dengan URL Web App Apps Script kamu
        $response = Http::withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0'
        ])->get('https://script.google.com/macros/s/AKfycbwS2F9Ogkhpdv3QP4m78fNtvFX6kn7Ia5Oo8wUcJJ74GwLavMSwmJlha309wdTULPX5/exec');
        $resellers = $response->json();

        return view('admin.reseller.reseller', compact('resellers'));
    }
}

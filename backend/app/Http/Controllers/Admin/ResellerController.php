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
        $response = Http::get('https://script.google.com/macros/s/AKfycbzP6ym1ybtYs_7qucriVoS9r5Pp-iqpgBliJVRq-RqOJBLm8-GJHOFNLfDKfK00rmns/exec');
        $resellers = $response->json();

        return view('admin.reseller.reseller', compact('resellers'));
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HewanKurban;

class DashboardController extends Controller
{
    public function index()
    {
        $totalHewan = HewanKurban::count();
        $totalTersedia = HewanKurban::where('status', 'tersedia')->count();
        $totalTerjual = HewanKurban::where('status', 'terjual')->count();

        return view('admin.dashboard.index', compact('totalHewan', 'totalTersedia', 'totalTerjual'));
    }
}
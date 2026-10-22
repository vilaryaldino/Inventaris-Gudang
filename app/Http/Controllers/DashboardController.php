<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MItem;
use App\Models\MSatuan;
use App\Models\MSatuanDasar;
use App\Models\MRekanan;

class DashboardController extends Controller
{
    public function index()
    {
        $totalItems = MItem::count();
        $totalSatuan = MSatuan::count();
        $totalRekanan = MRekanan::count();
        $totalSatuanDasar = MSatuanDasar::count();

        $recentItems = MItem::with('satuan')->latest('id')->take(5)->get();
        $rekanans = MRekanan::latest('id')->take(5)->get();

        return view('dashboard', compact(
            'totalItems',
            'totalSatuan',
            'totalRekanan',
            'totalSatuanDasar',
            'recentItems',
            'rekanans'
        ));
    }
}

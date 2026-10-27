<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MItem;
use App\Models\MSatuan;
use App\Models\MSatuanDasar;
use App\Models\MRekanan;

class MasterController extends Controller
{
    public function satuanDasar()
    {
        $data = MSatuanDasar::withCount('satuan')->orderBy('id')->get();
        return view('master.satuan_dasar', compact('data'));
    }

    public function satuan()
    {
        $data = MSatuan::with('satuanDasar')->orderBy('id')->get();
        $satuanDasarList = MSatuanDasar::orderBy('kode_satuan')->get();
        return view('master.satuan', compact('data', 'satuanDasarList'));
    }

    public function rekanan()
    {
        $data = MRekanan::orderBy('id')->get();
        return view('master.rekanan', compact('data'));
    }

    public function item()
    {
        $data = MItem::with(['satuan.satuanDasar'])->orderBy('id_barang')->get();
        $satuanList = MSatuan::orderBy('kode_satuan')->get();
        return view('master.item', compact('data', 'satuanList'));
    }
}

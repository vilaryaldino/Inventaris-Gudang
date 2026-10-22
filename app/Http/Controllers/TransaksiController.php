<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MItem;
use App\Models\MSatuan;
use App\Models\MSatuanDasar;
use App\Models\MRekanan;
use Carbon\Carbon;

class TransaksiController extends Controller
{
    /**
     * Tampilan Halaman Faktur Pembelian (Barang Masuk)
     */
    public function fakturPembelian()
    {
        // Ambil data master dari Oracle
        $rekanans = MRekanan::orderBy('nama_rekanan')->get();
        $items = MItem::with('satuan')->orderBy('kode_barang')->get();
        $satuans = MSatuan::orderBy('kode_satuan')->get();

        // Generate No. Transaksi otomatis: FP-YYYYMMDD-001
        $todayStr = Carbon::now()->format('Ymd');
        $noTransaksi = 'FP-' . $todayStr . '-001';
        $tglTransaksi = Carbon::now()->format('d/m/Y');
        $tglInsert = Carbon::now()->format('d/m/Y H:i');

        return view('transaksi.faktur_pembelian', compact(
            'rekanans',
            'items',
            'satuans',
            'noTransaksi',
            'tglTransaksi',
            'tglInsert'
        ));
    }

    /**
     * Tampilan Halaman Barang Keluar
     */
    public function barangKeluar()
    {
        $items = MItem::with('satuan')->orderBy('kode_barang')->get();
        $satuans = MSatuan::orderBy('kode_satuan')->get();
        $noTransaksi = 'BK-' . Carbon::now()->format('Ymd') . '-001';

        return view('transaksi.barang_keluar', compact('items', 'satuans', 'noTransaksi'));
    }
}

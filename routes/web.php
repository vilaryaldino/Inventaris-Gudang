<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransaksiController;
use App\Http\Controllers\MasterController;

// Dashboard
Route::get('/', [DashboardController::class, 'index'])->name('home');
Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Master Data
Route::prefix('master')->name('master.')->group(function () {
    Route::get('/satuan-dasar', [MasterController::class, 'satuanDasar'])->name('satuan-dasar');
    Route::get('/satuan', [MasterController::class, 'satuan'])->name('satuan');
    Route::get('/rekanan', [MasterController::class, 'rekanan'])->name('rekanan');
    Route::get('/item', [MasterController::class, 'item'])->name('item');
});

// Transaksi
Route::prefix('transaksi')->name('transaksi.')->group(function () {
    Route::get('/faktur-pembelian', [TransaksiController::class, 'fakturPembelian'])->name('faktur-pembelian');
    Route::post('/faktur-pembelian', [TransaksiController::class, 'storeFakturPembelian'])->name('faktur-pembelian.store');
    Route::get('/faktur-pembelian/po/{id}', [TransaksiController::class, 'getPurchaseOrder'])->name('faktur-pembelian.po');
    Route::get('/faktur-pembelian/{id}', [TransaksiController::class, 'showFakturPembelian'])->name('faktur-pembelian.show');
    Route::get('/faktur-pembelian/{id}/cetak', [TransaksiController::class, 'cetakFakturPembelian'])->name('faktur-pembelian.cetak');
    Route::delete('/faktur-pembelian/{id}', [TransaksiController::class, 'destroyFakturPembelian'])->name('faktur-pembelian.destroy');

    Route::get('/barang-keluar', [TransaksiController::class, 'barangKeluar'])->name('barang-keluar');
});

// Laporan (Placeholder for now)
Route::prefix('laporan')->name('laporan.')->group(function () {
    Route::get('/stok', function () {
        return redirect()->route('master.item')->with('info', 'Laporan stok barang dapat ditinjau melalui tabel Master Item.');
    })->name('stok');
    Route::get('/mutasi', function () {
        return redirect()->route('transaksi.faktur-pembelian')->with('info', 'Mutasi stok dicatat melalui menu Faktur Pembelian dan Pengeluaran Barang.');
    })->name('mutasi');
});

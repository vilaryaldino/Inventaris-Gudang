@extends('layouts.app')

@section('title', 'Pengeluaran Barang (Barang Keluar)')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">Pengeluaran Barang (Surat Jalan)</h1>
        <p style="font-size: 13px; color: #64748b;">Input transaksi pengeluaran barang dari gudang / surat jalan distribusi</p>
    </div>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Home</a>
        <span>/</span>
        <span>Barang Keluar</span>
    </div>
</div>

<div class="card-panel">
    <div class="card-panel-header">
        <i class="bi bi-file-earmark-arrow-up-fill text-primary"></i>
        <span>Informasi Pengeluaran Barang (No: {{ $noTransaksi }})</span>
    </div>
    <div class="card-panel-body">
        <div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 10px; padding: 32px; text-align: center;">
            <i class="bi bi-truck fs-1 text-primary mb-2"></i>
            <h3 style="font-size: 16px; font-weight: 700; color: #1e293b; margin-bottom: 6px;">Form Pengeluaran Barang Siap Digunakan</h3>
            <p style="font-size: 13px; color: #64748b; max-width: 500px; margin: 0 auto 16px;">
                Tersedia stok dari {{ count($items) }} master barang untuk dialokasikan ke surat jalan distribusi.
            </p>
            <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn btn-primary">
                <i class="bi bi-file-earmark-arrow-down-fill"></i> Buka Faktur Pembelian (Barang Masuk)
            </a>
        </div>
    </div>
</div>
@endsection

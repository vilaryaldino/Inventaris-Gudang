@extends('layouts.app')

@section('title', 'Dashboard Utama')

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #38bdf8 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #ffffff;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.35);
        position: relative;
        overflow: hidden;
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -40px;
        width: 220px;
        height: 220px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.1);
        pointer-events: none;
    }

    .welcome-text h1 {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 6px;
    }

    .welcome-text p {
        font-size: 14px;
        color: #e0f2fe;
        max-width: 600px;
        line-height: 1.5;
    }

    .welcome-action-btn {
        background-color: #ffffff;
        color: #1e40af;
        font-weight: 700;
        font-size: 13.5px;
        padding: 10px 20px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        transition: all 0.2s;
    }

    .welcome-action-btn:hover {
        background-color: #f8fafc;
        transform: translateY(-2px);
    }

    /* KPI Stats Grid */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 20px;
        margin-bottom: 28px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .kpi-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.08);
    }

    .kpi-icon {
        width: 52px;
        height: 52px;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        flex-shrink: 0;
    }

    .kpi-card.blue .kpi-icon { background: #eff6ff; color: #2563eb; }
    .kpi-card.green .kpi-icon { background: #ecfdf5; color: #10b981; }
    .kpi-card.purple .kpi-icon { background: #faf5ff; color: #a855f7; }
    .kpi-card.amber .kpi-icon { background: #fffbeb; color: #f59e0b; }

    .kpi-meta .label {
        font-size: 12px;
        font-weight: 600;
        color: #64748b;
        text-transform: uppercase;
        letter-spacing: 0.04em;
    }

    .kpi-meta .value {
        font-size: 26px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
        margin-top: 2px;
    }

    /* Dashboard 2 Column Section */
    .dashboard-split {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
    }

    .dash-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
        overflow: hidden;
    }

    .dash-panel-header {
        padding: 16px 20px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .dash-panel-header h3 {
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .dash-panel-header a {
        font-size: 12.5px;
        font-weight: 600;
        color: #2563eb;
        text-decoration: none;
    }

    .dash-panel-header a:hover {
        text-decoration: underline;
    }

    .dash-panel-body {
        padding: 16px 20px;
    }

    /* Quick Shortcuts Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .quick-btn {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        text-decoration: none;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        transition: all 0.2s ease;
    }

    .quick-btn:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        transform: translateY(-2px);
    }

    .quick-btn i {
        font-size: 24px;
        color: #2563eb;
    }

    .quick-btn strong {
        font-size: 13.5px;
        font-weight: 700;
    }

    .quick-btn span {
        font-size: 11.5px;
        color: #64748b;
    }

    @media (max-width: 900px) {
        .dashboard-split {
            grid-template-columns: 1fr;
        }
        .welcome-banner {
            flex-direction: column;
            align-items: flex-start;
            gap: 16px;
        }
    }
</style>
@endpush

@section('content')

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-text">
        <h1>Selamat Datang di Sistem Gudang</h1>
        <p>Kelola seluruh alur barang masuk (Faktur Pembelian), pengeluaran barang, serta data master barang dan rekanan secara terintegrasi dengan Oracle Database 11g.</p>
    </div>
    <a href="{{ route('transaksi.faktur-pembelian') }}" class="welcome-action-btn">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Input Faktur Baru</span>
    </a>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid">
    <div class="kpi-card blue">
        <div class="kpi-icon">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="kpi-meta">
            <div class="label">Total Item Barang</div>
            <div class="value">{{ $totalItems }}</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon">
            <i class="bi bi-building"></i>
        </div>
        <div class="kpi-meta">
            <div class="label">Rekanan / Vendor</div>
            <div class="value">{{ $totalRekanan }}</div>
        </div>
    </div>

    <div class="kpi-card purple">
        <div class="kpi-icon">
            <i class="bi bi-stack"></i>
        </div>
        <div class="kpi-meta">
            <div class="label">Satuan Konversi</div>
            <div class="value">{{ $totalSatuan }}</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon">
            <i class="bi bi-rulers"></i>
        </div>
        <div class="kpi-meta">
            <div class="label">Satuan Dasar</div>
            <div class="value">{{ $totalSatuanDasar }}</div>
        </div>
    </div>
</div>

<!-- Dashboard 2-Columns -->
<div class="dashboard-split">
    
    <!-- Kolom Kiri: Tabel Barang Terbaru -->
    <div class="dash-panel">
        <div class="dash-panel-header">
            <h3><i class="bi bi-boxes text-primary"></i> Master Barang Terbaru</h3>
            <a href="{{ route('master.item') }}">Lihat Semua Item &rarr;</a>
        </div>
        <div class="dash-panel-body" style="padding: 0;">
            <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
                <thead>
                    <tr style="background: #f8fafc; border-bottom: 1px solid #e2e8f0; color: #475569;">
                        <th style="padding: 10px 16px; text-align: left;">Kode</th>
                        <th style="padding: 10px 16px; text-align: left;">Nama Barang</th>
                        <th style="padding: 10px 16px; text-align: left;">Satuan</th>
                        <th style="padding: 10px 16px; text-align: right;">Estimasi Harga</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentItems as $item)
                        <tr style="border-bottom: 1px solid #f1f5f9;">
                            <td style="padding: 10px 16px; font-weight: 700; color: #1e40af;">{{ $item->kode_barang }}</td>
                            <td style="padding: 10px 16px;">{{ $item->nama_barang }}</td>
                            <td style="padding: 10px 16px;">
                                <span style="background: #eff6ff; color: #2563eb; padding: 3px 8px; border-radius: 4px; font-size: 11px; font-weight: 600;">
                                    {{ $item->satuan?->kode_satuan ?? '-' }}
                                </span>
                            </td>
                            <td style="padding: 10px 16px; text-align: right; font-weight: 600; color: #0f172a;">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="padding: 20px; text-align: center; color: #94a3b8;">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Kolom Kanan: Pintasan Cepat & Rekanan -->
    <div>
        <div class="dash-panel" style="margin-bottom: 24px;">
            <div class="dash-panel-header">
                <h3><i class="bi bi-lightning-charge-fill text-warning"></i> Menu Pintasan Cepat</h3>
            </div>
            <div class="dash-panel-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('transaksi.faktur-pembelian') }}" class="quick-btn">
                        <i class="bi bi-file-earmark-arrow-down-fill text-primary"></i>
                        <strong>Faktur Beli</strong>
                        <span>Barang Masuk</span>
                    </a>
                    <a href="{{ route('transaksi.barang-keluar') }}" class="quick-btn">
                        <i class="bi bi-file-earmark-arrow-up-fill" style="color: #64748b;"></i>
                        <strong>Barang Keluar</strong>
                        <span>Surat Jalan</span>
                    </a>
                    <a href="{{ route('master.item') }}" class="quick-btn">
                        <i class="bi bi-box-seam text-success"></i>
                        <strong>Master Item</strong>
                        <span>Katalog Barang</span>
                    </a>
                    <a href="{{ route('master.rekanan') }}" class="quick-btn">
                        <i class="bi bi-building text-purple" style="color: #a855f7;"></i>
                        <strong>Rekanan</strong>
                        <span>Vendor/Supplier</span>
                    </a>
                </div>
            </div>
        </div>

        <div class="dash-panel">
            <div class="dash-panel-header">
                <h3><i class="bi bi-building text-primary"></i> Rekanan Terdaftar</h3>
                <a href="{{ route('master.rekanan') }}">Detail &rarr;</a>
            </div>
            <div class="dash-panel-body" style="padding: 8px 16px;">
                @foreach($rekanans as $rek)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 10px 0; border-bottom: 1px solid #f1f5f9;">
                        <div>
                            <strong style="font-size: 13px; color: #0f172a; display: block;">{{ $rek->nama_rekanan }}</strong>
                            <span style="font-size: 11px; color: #64748b;">{{ $rek->kode_rekanan }} · {{ $rek->alamat ?? 'Indonesia' }}</span>
                        </div>
                        <span style="font-size: 11px; color: #2563eb; font-weight: 600;">{{ $rek->no_telp ?? '-' }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

</div>

@endsection

@extends('layouts.app')

@section('title', 'Dashboard Utama')

@push('styles')
<style>
    .welcome-banner {
        background: linear-gradient(135deg, #0f172a 0%, #1e3a8a 50%, #2563eb 100%);
        border-radius: 16px;
        padding: 28px 32px;
        color: #ffffff;
        margin-bottom: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        box-shadow: 0 10px 25px -5px rgba(37, 99, 235, 0.25);
  
  
  
  
        position: relative;
        overflow: hidden;
        border: 1px solid rgba(255, 255, 255, 0.1);
    }

    .welcome-banner::after {
        content: '';
        position: absolute;
        right: -30px;
        top: -40px;
        width: 240px;
        height: 240px;
                                                     border-radius: 50%;
        background: radial-gradient(circle, rgba(56, 189, 248, 0.2) 0%, rgba(37, 99, 235, 0) 70%);
        pointer-events: none;
    }

    .welcome-text h1 {
        font-size: 24px;
        font-weight: 800;
        letter-spacing: -0.02em;
        margin-bottom: 8px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .welcome-text p {
        font-size: 13.5px;
        color: #e0f2fe;
        max-width: 640px;
        line-height: 1.6;
    }

    .welcome-date-badge {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: rgba(255, 255, 255, 0.15);
        backdrop-filter: blur(8px);
        padding: 4px 12px;
        border-radius: 9999px;
        font-size: 11.5px;
        font-weight: 600;
        margin-bottom: 12px;
        border: 1px solid rgba(255, 255, 255, 0.2);
    }

    .welcome-action-btn {
        background-color: #ffffff;
        color: #1e40af;
        font-weight: 700;
        font-size: 13.5px;
        padding: 12px 22px;
        border-radius: 10px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.2);
        transition: all 0.2s ease;
        flex-shrink: 0;
    }

    .welcome-action-btn:hover {
        background-color: #f8fafc;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25);
    }

    /* Dashboard Split Layout */
    .dashboard-split {
        display: grid;
        grid-template-columns: 2fr 1.2fr;
        gap: 24px;
    }

    /* Quick Shortcuts Grid */
    .quick-actions-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 14px;
    }

    .quick-btn {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: var(--radius-md);
        padding: 16px;
        text-decoration: none;
        color: #1e293b;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        gap: 8px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
    }

    .quick-btn:hover {
        background: #eff6ff;
        border-color: #bfdbfe;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.1);
    }

    .quick-btn i {
        font-size: 24px;
    }

    .quick-btn strong {
        font-size: 13.5px;
        font-weight: 700;
        color: #0f172a;
    }

    .quick-btn span {
        font-size: 11.5px;
        color: #64748b;
    }

    @media (max-width: 960px) {
        .dashboard-split {
            grid-template-columns: 1fr;
        }
        .welcome-banner {
            flex-direction: column;
            align-items: flex-start;
            gap: 20px;
        }
    }
</style>
@endpush

@section('content')

<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-text">
        <div class="welcome-date-badge">
            <i class="bi bi-calendar3"></i>
            <span>{{ \Carbon\Carbon::now()->isoFormat('dddd, D MMMM Y') }}</span>
        </div>
        <h1>Selamat Datang di Sistem Gudang Enterprise</h1>
        <p>Sistem manajemen logistik pergudangan terpadu dengan Oracle Database 11g. Kelola penerimaan faktur pembelian, pengeluaran barang, serta katalog master data secara cepat dan akurat.</p>
    </div>
    <a href="{{ route('transaksi.faktur-pembelian') }}" class="welcome-action-btn">
        <i class="bi bi-plus-circle-fill"></i>
        <span>Input Faktur Baru</span>
    </a>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid">
    <div class="kpi-card blue">
        <div class="kpi-icon blue">
            <i class="bi bi-box-seam-fill"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ $totalItems }}</div>
            <div class="label">Total Item Barang</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon emerald">
            <i class="bi bi-building"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ $totalRekanan }}</div>
            <div class="label">Rekanan / Vendor</div>
        </div>
    </div>

    <div class="kpi-card purple">
        <div class="kpi-icon purple">
            <i class="bi bi-stack"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ $totalSatuan }}</div>
            <div class="label">Satuan Konversi</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon amber">
            <i class="bi bi-rulers"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ $totalSatuanDasar }}</div>
            <div class="label">Satuan Dasar</div>
        </div>
    </div>
</div>

<!-- Dashboard 2-Columns Split -->
<div class="dashboard-split">
    
    <!-- Kolom Kiri: Tabel Barang Terbaru -->
    <div class="card-panel">
        <div class="card-panel-header">
            <div class="header-title">
                <i class="bi bi-boxes"></i>
                <span>Master Barang Terbaru</span>
            </div>
            <a href="{{ route('master.item') }}" style="color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none; display: flex; align-items: center; gap: 4px;">
                <span>Lihat Semua Item</span>
                <i class="bi bi-arrow-right"></i>
            </a>
        </div>
        <div class="card-panel-body" style="padding: 0;">
            <div class="table-container" style="border: none; margin-bottom: 0;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th style="width: 140px;">Kode</th>
                            <th>Nama Barang</th>
                            <th style="width: 120px;">Satuan</th>
                            <th style="width: 160px; text-align: right;">Estimasi Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentItems as $item)
                            <tr>
                                <td>
                                    <span class="badge-code">{{ $item->kode_barang }}</span>
                                </td>
                                <td>
                                    <div style="font-weight: 600; color: #0f172a;">{{ $item->nama_barang }}</div>
                                </td>
                                <td>
                                    <span class="badge-pill badge-blue">
                                        {{ $item->satuan?->kode_satuan ?? '-' }}
                                    </span>
                                </td>
                                <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                    Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="padding: 36px 20px; text-align: center; color: #94a3b8;">
                                    <i class="bi bi-inbox" style="font-size: 28px; display: block; margin-bottom: 8px;"></i>
                                    <span>Belum ada data barang.</span>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
        <div class="card-panel-footer">
            <span>Data master disinkronkan otomatis dari Oracle Database.</span>
            <a href="{{ route('master.item') }}" class="btn btn-secondary btn-sm">Buka Master Item</a>
        </div>
    </div>

    <!-- Kolom Kanan: Pintasan Cepat & Rekanan -->
    <div>
        <!-- Menu Pintasan Cepat -->
        <div class="card-panel" style="margin-bottom: 24px;">
            <div class="card-panel-header">
                <div class="header-title">
                    <i class="bi bi-lightning-charge-fill" style="color: #f59e0b;"></i>
                    <span>Menu Pintasan Cepat</span>
                </div>
            </div>
            <div class="card-panel-body">
                <div class="quick-actions-grid">
                    <a href="{{ route('transaksi.faktur-pembelian') }}" class="quick-btn">
                        <i class="bi bi-file-earmark-arrow-down-fill" style="color: #2563eb;"></i>
                        <strong>Faktur Beli</strong>
                        <span>Barang Masuk</span>
                    </a>
                    <a href="{{ route('transaksi.barang-keluar') }}" class="quick-btn">
                        <i class="bi bi-file-earmark-arrow-up-fill" style="color: #64748b;"></i>
                        <strong>Barang Keluar</strong>
                        <span>Surat Jalan</span>
                    </a>
                    <a href="{{ route('master.item') }}" class="quick-btn">
                        <i class="bi bi-box-seam" style="color: #10b981;"></i>
                        <strong>Master Item</strong>
                        <span>Katalog Barang</span>
                    </a>
                    <a href="{{ route('master.rekanan') }}" class="quick-btn">
                        <i class="bi bi-building" style="color: #a855f7;"></i>
                        <strong>Rekanan</strong>
                        <span>Vendor/Supplier</span>
                    </a>
                </div>
            </div>
        </div>

        <!-- Rekanan Terdaftar -->
        <div class="card-panel">
            <div class="card-panel-header">
                <div class="header-title">
                    <i class="bi bi-building"></i>
                    <span>Rekanan Terdaftar</span>
                </div>
                <a href="{{ route('master.rekanan') }}" style="color: var(--primary); font-size: 13px; font-weight: 600; text-decoration: none;">
                    <span>Detail</span> &rarr;
                </a>
            </div>
            <div class="card-panel-body" style="padding: 12px 20px;">
                @forelse($rekanans as $rek)
                    <div style="display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid #f1f5f9;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 32px; height: 32px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 11.5px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                                {{ strtoupper(substr($rek->nama_rekanan, 0, 2)) }}
                            </div>
                            <div>
                                <strong style="font-size: 13px; color: #0f172a; display: block;">{{ $rek->nama_rekanan }}</strong>
                                <span style="font-size: 11px; color: #64748b;">{{ $rek->kode_rekanan }} · {{ Str::limit($rek->alamat ?? 'Indonesia', 26) }}</span>
                            </div>
                        </div>
                        @if($rek->no_telp)
                            <span class="badge-pill badge-slate" style="font-size: 11px; font-family: ui-monospace, monospace;">
                                {{ $rek->no_telp }}
                            </span>
                        @endif
                    </div>
                @empty
                    <div style="text-align: center; color: #94a3b8; padding: 20px;">Belum ada rekanan.</div>
                @endforelse
            </div>
        </div>
    </div>

</div>

@endsection

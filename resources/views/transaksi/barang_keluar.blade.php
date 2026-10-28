@extends('layouts.app')

@section('title', 'Pengeluaran Barang (Surat Jalan)')

@section('content')

<!-- Header Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon" style="background: linear-gradient(135deg, #475569 0%, #1e293b 100%);">
            <i class="bi bi-file-earmark-arrow-up-fill"></i>
        </div>
        <div>
            <h1>Pengeluaran Barang (Surat Jalan)</h1>
            <p>Pencatatan alokasi logistik keluar dari gudang untuk pengiriman & distribusi barang</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Transaksi</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Barang Keluar</span>
        </div>
        <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn btn-secondary">
            <i class="bi bi-file-earmark-arrow-down-fill text-primary"></i> Faktur Beli (Masuk)
        </a>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 24px;">
    <div class="kpi-card blue">
        <div class="kpi-icon blue">
            <i class="bi bi-receipt"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 19px; font-family: ui-monospace, monospace;">{{ $noTransaksi }}</div>
            <div class="label">No. Transaksi Draft</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon emerald">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($items) }}</div>
            <div class="label">Barang Siap Dialokasi</div>
        </div>
    </div>

    <div class="kpi-card purple">
        <div class="kpi-icon purple">
            <i class="bi bi-truck"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 18px;">DISTRIBUSI</div>
            <div class="label">Alur Logistik Keluar</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon amber">
            <i class="bi bi-clock-history"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 18px;">{{ date('d/m/Y') }}</div>
            <div class="label">Tanggal Pengeluaran</div>
        </div>
    </div>
</div>

<!-- Overview Box -->
<div class="card-panel" style="margin-bottom: 24px;">
    <div class="card-panel-header">
        <div class="header-title">
            <i class="bi bi-info-circle-fill text-primary"></i>
            <span>Status Modul Pengeluaran Barang</span>
            <span class="badge-pill badge-emerald">Modul Siap</span>
        </div>
        <span class="badge-pill badge-slate">Format: {{ $noTransaksi }}</span>
    </div>
    <div class="card-panel-body">
        <div style="background-color: #f8fafc; border: 1px dashed #cbd5e1; border-radius: 12px; padding: 28px; text-align: center;">
            <div style="width: 56px; height: 56px; border-radius: 50%; background: #eff6ff; color: #2563eb; display: inline-flex; align-items: center; justify-content: center; font-size: 26px; margin-bottom: 12px;">
                <i class="bi bi-truck"></i>
            </div>
            <h3 style="font-size: 17px; font-weight: 700; color: #0f172a; margin-bottom: 6px;">
                Form Pengeluaran Barang (Surat Jalan Distribusi)
            </h3>
            <p style="font-size: 13.5px; color: #64748b; max-width: 580px; margin: 0 auto 18px; line-height: 1.6;">
                Tersedia stok dari <strong>{{ count($items) }} master barang</strong> untuk dialokasikan ke surat jalan pengeluaran. Anda dapat meninjau katalog item di bawah atau menginput faktur penerimaan masuk terlebih dahulu.
            </p>
            <div style="display: inline-flex; gap: 10px; flex-wrap: wrap; justify-content: center;">
                <button type="button" class="btn btn-primary" onclick="alert('Formulir surat jalan pengeluaran baru dibuka')">
                    <i class="bi bi-plus-circle-fill"></i> Buat Surat Jalan Baru
                </button>
                <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn btn-secondary">
                    <i class="bi bi-file-earmark-arrow-down-fill text-primary"></i> Buka Faktur Pembelian (Masuk)
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Table Card Panel: Katalog Item yang Tersedia untuk Dikeluarkan -->
<div class="card-panel">
    <div class="card-panel-header">
        <div class="header-title">
            <i class="bi bi-boxes"></i>
            <span>Katalog Master Item Siap Pengeluaran</span>
            <span class="badge-pill badge-blue">{{ count($items) }} Item</span>
        </div>
        <div class="search-input-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchBarangKeluar" placeholder="Cari item yang akan dikeluarkan..." onkeyup="filterTable('searchBarangKeluar', 'tableBarangKeluar')">
        </div>
    </div>
    
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table" id="tableBarangKeluar">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 140px;">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="width: 150px;">Satuan Keluar</th>
                        <th style="width: 180px; text-align: right;">Estimasi Nilai Satuan</th>
                        <th style="width: 140px; text-align: center;">Aksi Alokasi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($items as $index => $it)
                        <tr>
                            <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge-code">{{ $it->kode_barang }}</span>
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #0f172a;">{{ $it->nama_barang }}</div>
                            </td>
                            <td>
                                <span class="badge-pill badge-blue">
                                    {{ $it->satuan?->kode_satuan ?? '-' }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                Rp {{ number_format($it->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td style="text-align: center;">
                                <button type="button" class="btn btn-secondary btn-sm" onclick="alert('Alokasi barang {{ $it->kode_barang }} ke Surat Jalan')" style="padding: 4px 10px; font-size: 11.5px;">
                                    <i class="bi bi-box-arrow-up-right text-primary"></i> Alokasi
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                Belum ada data item barang.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-panel-footer">
        <span>Menampilkan katalog barang yang dapat dicatat pada surat jalan pengeluaran.</span>
        <span>Oracle OCI8 · Sinkronisasi Realtime</span>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function filterTable(inputId, tableId) {
        const query = document.getElementById(inputId).value.toLowerCase();
        const rows = document.querySelectorAll('#' + tableId + ' tbody tr');
        rows.forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
        });
    }
</script>
@endpush

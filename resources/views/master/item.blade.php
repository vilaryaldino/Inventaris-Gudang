@extends('layouts.app')

@section('title', 'Master Barang (Item)')

@section('content')

<!-- Header Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-boxes"></i>
        </div>
        <div>
            <h1>Master Barang (Item)</h1>
            <p>Kelola katalog barang gudang, satuan acuan transaksi, dan estimasi harga standar</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Master Data</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Master Barang</span>
        </div>
        <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn btn-secondary">
            <i class="bi bi-file-earmark-plus"></i> Transaksi Masuk
        </a>
        <button type="button" class="btn btn-primary" onclick="alert('Form tambah item master dibuka (Oracle Seq auto-increment)')">
            <i class="bi bi-plus-lg"></i> Tambah Barang Baru
        </button>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 24px;">
    <div class="kpi-card blue">
        <div class="kpi-icon blue">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($data) }}</div>
            <div class="label">Total Item Barang</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon emerald">
            <i class="bi bi-tag-fill"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 20px;">Rp {{ number_format($data->avg('harga_satuan') ?? 0, 0, ',', '.') }}</div>
            <div class="label">Rata-rata Harga Satuan</div>
        </div>
    </div>

    <div class="kpi-card purple">
        <div class="kpi-icon purple">
            <i class="bi bi-stack"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($satuanList) }}</div>
            <div class="label">Satuan Konversi Tersedia</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon amber">
            <i class="bi bi-database-check"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 18px; padding-top: 4px;">M_ITEM</div>
            <div class="label">Oracle 11g Schema Table</div>
        </div>
    </div>
</div>

<!-- Table Card Panel -->
<div class="card-panel">
    <div class="card-panel-header">
        <div class="header-title">
            <i class="bi bi-table"></i>
            <span>Katalog Master Item Barang</span>
            <span class="badge-pill badge-blue">{{ count($data) }} Item</span>
        </div>
        <div class="search-input-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchItem" placeholder="Cari kode, nama barang, atau satuan..." onkeyup="filterTable('searchItem', 'tableItem')">
        </div>
    </div>
    
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table" id="tableItem">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 140px;">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="width: 150px;">Satuan Transaksi</th>
                        <th style="width: 150px;">Satuan Dasar</th>
                        <th style="width: 180px; text-align: right;">Estimasi Harga (Rp)</th>
                        <th style="width: 110px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr>
                            <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge-code">{{ $item->kode_barang }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <i class="bi bi-box text-primary" style="font-size: 15px;"></i>
                                    <div>
                                        <strong style="color: #0f172a; font-size: 13.5px; display: block;">{{ $item->nama_barang }}</strong>
                                        <span style="font-size: 11px; color: #64748b;">ID Barang: {{ $item->id_barang }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="badge-pill badge-blue">
                                    <i class="bi bi-tag"></i>
                                    {{ $item->satuan?->kode_satuan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span class="badge-pill badge-slate">
                                    {{ $item->satuanDasar?->nama_satuan ?? ($item->satuan?->kode_satuan ?? '-') }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                <span style="font-family: ui-monospace, SFMono-Regular, monospace; background: #f8fafc; padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Item" onclick="alert('Edit item {{ $item->nama_barang }}')">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Item" onclick="if(confirm('Hapus item {{ $item->nama_barang }}?')) alert('Fitur hapus item')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <i class="bi bi-inbox" style="font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <span style="font-size: 14px; font-weight: 600;">Belum ada data barang.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-panel-footer">
        <span>Menampilkan <strong>{{ count($data) }}</strong> item barang terdaftar.</span>
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

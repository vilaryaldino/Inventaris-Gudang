@extends('layouts.app')

@section('title', 'Master Satuan Konversi')

@section('content')

<!-- Header Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-stack"></i>
        </div>
        <div>
            <h1>Master Satuan Konversi</h1>
            <p>Kelola satuan transaksi beserta faktor konversi ke satuan unit dasar</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Master Data</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Satuan Konversi</span>
        </div>
        <button type="button" class="btn btn-primary" onclick="alert('Form tambah satuan konversi dibuka')">
            <i class="bi bi-plus-lg"></i> Tambah Satuan Baru
        </button>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 24px;">
    <div class="kpi-card blue">
        <div class="kpi-icon blue">
            <i class="bi bi-stack"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($data) }}</div>
            <div class="label">Total Satuan Konversi</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon emerald">
            <i class="bi bi-rulers"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($satuanDasarList) }}</div>
            <div class="label">Satuan Dasar Induk</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon amber">
            <i class="bi bi-database-check"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 18px; padding-top: 4px;">M_SATUAN</div>
            <div class="label">Oracle 11g Schema Table</div>
        </div>
    </div>
</div>

<!-- Table Card Panel -->
<div class="card-panel">
    <div class="card-panel-header">
        <div class="header-title">
            <i class="bi bi-table"></i>
            <span>Daftar Satuan Konversi Terdaftar</span>
            <span class="badge-pill badge-blue">{{ count($data) }} Data</span>
        </div>
        <div class="search-input-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchSatuan" placeholder="Cari satuan atau konversi..." onkeyup="filterTable('searchSatuan', 'tableSatuan')">
        </div>
    </div>
    
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table" id="tableSatuan">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th style="width: 150px;">Kode Satuan</th>
                        <th>Nama Satuan</th>
                        <th style="width: 220px;">Satuan Dasar (Induk)</th>
                        <th style="width: 170px; text-align: right;">Nilai Konversi</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $sat)
                        <tr>
                            <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge-code">{{ $sat->kode_satuan }}</span>
                            </td>
                            <td>
                                <strong style="color: #0f172a; font-size: 13.5px;">{{ $sat->nama_satuan }}</strong>
                            </td>
                            <td>
                                <span class="badge-pill badge-slate">
                                    <i class="bi bi-arrow-right-short text-primary"></i>
                                    {{ $sat->satuanDasar?->nama_satuan ?? '-' }} 
                                    <strong style="color: #1e40af;">({{ $sat->satuanDasar?->kode_satuan ?? '-' }})</strong>
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                <span style="font-family: ui-monospace, SFMono-Regular, monospace; background: #f8fafc; padding: 4px 10px; border-radius: 6px; border: 1px solid #e2e8f0;">
                                    {{ number_format($sat->konversi, 4, ',', '.') }}
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Satuan" onclick="alert('Edit satuan {{ $sat->kode_satuan }}')">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Satuan" onclick="if(confirm('Hapus satuan {{ $sat->kode_satuan }}?')) alert('Fitur hapus satuan')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <i class="bi bi-inbox" style="font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <span style="font-size: 14px; font-weight: 600;">Belum ada data satuan konversi.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-panel-footer">
        <span>Menampilkan <strong>{{ count($data) }}</strong> data satuan konversi.</span>
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

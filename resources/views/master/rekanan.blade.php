@extends('layouts.app')

@section('title', 'Data Rekanan (Supplier & Vendor)')

@section('content')

<!-- Header Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-building"></i>
        </div>
        <div>
            <h1>Data Rekanan (Supplier & Vendor)</h1>
            <p>Kelola daftar mitra supplier & vendor pemasok barang untuk pencatatan faktur pembelian</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 12px; flex-wrap: wrap;">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Master Data</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Data Rekanan</span>
        </div>
        <button type="button" class="btn btn-primary" onclick="alert('Form tambah rekanan master dibuka (Oracle Seq auto-increment)')">
            <i class="bi bi-plus-lg"></i> Tambah Rekanan Baru
        </button>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid" style="grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); margin-bottom: 24px;">
    <div class="kpi-card blue">
        <div class="kpi-icon blue">
            <i class="bi bi-building"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($data) }}</div>
            <div class="label">Total Rekanan / Vendor</div>
        </div>
    </div>

    <div class="kpi-card green">
        <div class="kpi-icon emerald">
            <i class="bi bi-check-circle-fill"></i>
        </div>
        <div class="kpi-meta">
            <div class="value">{{ count($data) }}</div>
            <div class="label">Mitra Terverifikasi</div>
        </div>
    </div>

    <div class="kpi-card amber">
        <div class="kpi-icon amber">
            <i class="bi bi-database-check"></i>
        </div>
        <div class="kpi-meta">
            <div class="value" style="font-size: 18px; padding-top: 4px;">M_REKANAN</div>
            <div class="label">Oracle 11g Schema Table</div>
        </div>
    </div>
</div>

<!-- Table Card Panel -->
<div class="card-panel">
    <div class="card-panel-header">
        <div class="header-title">
            <i class="bi bi-table"></i>
            <span>Daftar Rekanan & Supplier Terdaftar</span>
            <span class="badge-pill badge-blue">{{ count($data) }} Rekanan</span>
        </div>
        <div class="search-input-wrap">
            <i class="bi bi-search"></i>
            <input type="text" id="searchRekanan" placeholder="Cari rekanan, alamat, atau telepon..." onkeyup="filterTable('searchRekanan', 'tableRekanan')">
        </div>
    </div>
    
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table" id="tableRekanan">
                <thead>
                    <tr>
                        <th style="width: 60px; text-align: center;">No</th>
                        <th style="width: 150px;">Kode Rekanan</th>
                        <th style="width: 280px;">Nama Rekanan / Perusahaan</th>
                        <th>Alamat Lengkap</th>
                        <th style="width: 180px;">No. Telepon / HP</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $rek)
                        <tr>
                            <td style="text-align: center; color: #64748b; font-weight: 600;">{{ $index + 1 }}</td>
                            <td>
                                <span class="badge-code">{{ $rek->kode_rekanan }}</span>
                            </td>
                            <td>
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 34px; height: 34px; border-radius: 8px; background: #eff6ff; color: #2563eb; display: flex; align-items: center; justify-content: center; font-weight: 700; font-size: 12px; border: 1px solid #bfdbfe; flex-shrink: 0;">
                                        {{ strtoupper(substr($rek->nama_rekanan, 0, 2)) }}
                                    </div>
                                    <div>
                                        <strong style="color: #0f172a; font-size: 13.5px; display: block;">{{ $rek->nama_rekanan }}</strong>
                                        <span style="font-size: 11px; color: #64748b;">ID: {{ $rek->id }}</span>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div style="display: flex; align-items: flex-start; gap: 6px; color: #475569;">
                                    <i class="bi bi-geo-alt text-muted" style="margin-top: 2px;"></i>
                                    <span>{{ $rek->alamat ?? 'Indonesia' }}</span>
                                </div>
                            </td>
                            <td>
                                @if($rek->no_telp)
                                    <span class="badge-pill badge-blue" style="font-family: ui-monospace, monospace;">
                                        <i class="bi bi-telephone-fill"></i>
                                        {{ $rek->no_telp }}
                                    </span>
                                @else
                                    <span style="color: #94a3b8;">-</span>
                                @endif
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Rekanan" onclick="alert('Edit rekanan {{ $rek->nama_rekanan }}')">
                                        <i class="bi bi-pencil-fill"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Rekanan" onclick="if(confirm('Hapus rekanan {{ $rek->nama_rekanan }}?')) alert('Fitur hapus rekanan')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 48px 20px; color: #94a3b8;">
                                <i class="bi bi-inbox" style="font-size: 36px; display: block; margin-bottom: 10px; color: #cbd5e1;"></i>
                                <span style="font-size: 14px; font-weight: 600;">Belum ada data rekanan.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-panel-footer">
        <span>Menampilkan <strong>{{ count($data) }}</strong> data rekanan supplier.</span>
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

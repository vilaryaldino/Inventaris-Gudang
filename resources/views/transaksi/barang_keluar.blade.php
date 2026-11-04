@extends('layouts.app')

@section('title', 'Bukti Barang Keluar (Bon Keluar)')

@push('styles')
<style>
    /* Page Layout & Headers */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
        flex-wrap: wrap;
        gap: 16px;
    }

    .page-title-box {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
        width: 48px;
        height: 48px;
        background: linear-gradient(135deg, #dc2626, #991b1b);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 24px;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }

    .page-title-box h1 {
        font-size: 22px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .page-title-box p {
        font-size: 13px;
        color: #64748b;
        margin-top: 3px;
    }

    /* KPI Summary Cards */
    .kpi-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
        gap: 18px;
        margin-bottom: 24px;
    }

    .kpi-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 18px 20px;
        display: flex;
        align-items: center;
        gap: 16px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        transition: transform 0.2s, box-shadow 0.2s;
    }

    .kpi-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.06);
    }

    .kpi-icon {
        width: 46px;
        height: 46px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
    }

    .kpi-icon.red { background: #fef2f2; color: #dc2626; }
    .kpi-icon.blue { background: #eff6ff; color: #2563eb; }
    .kpi-icon.emerald { background: #ecfdf5; color: #059669; }
    .kpi-icon.amber { background: #fffbeb; color: #d97706; }

    .kpi-meta h3 {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
        line-height: 1.2;
    }

    .kpi-meta p {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Tab Switcher */
    .nav-tabs-custom {
        display: flex;
        gap: 10px;
        border-bottom: 1px solid var(--border-color);
        margin-bottom: 24px;
        padding-bottom: 12px;
        flex-wrap: wrap;
    }

    .tab-btn {
        background: #ffffff;
        border: 1px solid var(--border-color);
        padding: 10px 20px;
        font-size: 13.5px;
        font-weight: 600;
        color: #64748b;
        cursor: pointer;
        display: flex;
        align-items: center;
        gap: 10px;
        border-radius: 9999px;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        box-shadow: 0 1px 2px rgba(0, 0, 0, 0.04);
    }

    .tab-btn:hover {
        color: #dc2626;
        border-color: #fecaca;
        background: #fef2f2;
        transform: translateY(-1px);
    }

    .tab-btn.active {
        color: #ffffff;
        background: linear-gradient(180deg, #dc2626 0%, #b91c1c 100%);
        border-color: #b91c1c;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(220, 38, 38, 0.25);
    }

    .tab-badge {
        background: rgba(255, 255, 255, 0.2);
        color: inherit;
        font-size: 11px;
        font-weight: 700;
        padding: 2px 8px;
        border-radius: 999px;
    }

    .tab-btn:not(.active) .tab-badge {
        background: #f1f5f9;
        color: #64748b;
    }

    /* Card Panels & Forms */
    .card-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-panel-header {
        padding: 16px 20px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
        font-weight: 700;
        color: #0f172a;
        font-size: 14.5px;
    }

    .card-panel-body {
        padding: 24px;
    }

    /* Delphi Style Top Header Grid */
    .delphi-header-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 20px 24px;
        margin-bottom: 20px;
        box-shadow: 0 1px 3px rgba(0,0,0,0.03);
    }

    .delphi-top-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-bottom: 1px solid #f1f5f9;
        padding-bottom: 14px;
        margin-bottom: 18px;
        flex-wrap: wrap;
        gap: 12px;
    }

    .delphi-title {
        font-size: 18px;
        font-weight: 800;
        color: #0f172a;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .delphi-trx-badge {
        font-size: 17px;
        font-weight: 900;
        color: #dc2626;
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        letter-spacing: 0.5px;
        background: #fef2f2;
        padding: 4px 14px;
        border-radius: 8px;
        border: 1px solid #fecaca;
    }

    .delphi-grid {
        display: grid;
        grid-template-columns: 1.4fr 0.8fr 1.3fr;
        gap: 20px;
    }

    @media (max-width: 992px) {
        .delphi-grid {
            grid-template-columns: 1fr;
        }
    }

    .form-group-custom {
        margin-bottom: 14px;
    }

    .form-group-custom label {
        display: block;
        font-size: 12px;
        font-weight: 700;
        color: #334155;
        margin-bottom: 6px;
        text-transform: uppercase;
        letter-spacing: 0.3px;
    }

    .form-group-custom label .required {
        color: #dc2626;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 9px 12px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 13px;
        font-family: inherit;
        color: #0f172a;
        background-color: #ffffff;
        transition: border-color 0.2s, box-shadow 0.2s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #dc2626;
        outline: none;
        box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.12);
    }

    .valid-stamp {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 2px solid #16a34a;
        color: #16a34a;
        font-weight: 900;
        font-size: 14px;
        padding: 6px 16px;
        border-radius: 8px;
        letter-spacing: 2px;
        text-transform: uppercase;
        background: #f0fdf4;
        transform: rotate(-3deg);
        user-select: none;
        box-shadow: 0 2px 6px rgba(22, 163, 74, 0.15);
    }

    /* Buttons */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 9px 16px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        border: none;
        cursor: pointer;
        transition: all 0.2s;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: linear-gradient(180deg, #dc2626 0%, #b91c1c 100%);
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(220, 38, 38, 0.25);
    }

    .btn-primary-custom:hover {
        background: linear-gradient(180deg, #b91c1c 0%, #991b1b 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-secondary-custom {
        background: #ffffff;
        color: #475569;
        border: 1px solid #cbd5e1;
    }

    .btn-secondary-custom:hover {
        background: #f8fafc;
        color: #0f172a;
        border-color: #94a3b8;
    }

    .btn-success-custom {
        background: linear-gradient(180deg, #16a34a 0%, #15803d 100%);
        color: #ffffff;
        box-shadow: 0 2px 6px rgba(22, 163, 74, 0.25);
    }

    .btn-success-custom:hover {
        background: linear-gradient(180deg, #15803d 0%, #166534 100%);
        color: #ffffff;
        transform: translateY(-1px);
    }

    .btn-sm-action {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #64748b;
        cursor: pointer;
        transition: all 0.15s;
        text-decoration: none;
    }

    .btn-sm-action:hover {
        color: #0f172a;
        background: #f1f5f9;
        border-color: #cbd5e1;
    }

    .btn-sm-action.detail:hover { color: #2563eb; background: #eff6ff; border-color: #bfdbfe; }
    .btn-sm-action.print:hover { color: #059669; background: #ecfdf5; border-color: #a7f3d0; }
    .btn-sm-action.delete:hover { color: #dc2626; background: #fef2f2; border-color: #fecaca; }

    /* Tables */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        text-align: left;
        font-size: 13px;
    }

    .data-table th {
        background-color: #f8fafc;
        color: #475569;
        font-weight: 700;
        padding: 12px 14px;
        border-bottom: 2px solid #cbd5e1;
        white-space: nowrap;
        font-size: 11.5px;
        text-transform: uppercase;
        letter-spacing: 0.03em;
    }

    .data-table td {
        padding: 10px 14px;
        border-bottom: 1px solid #e2e8f0;
        color: #1e293b;
        vertical-align: middle;
    }

    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }

    /* Badges */
    .badge-code {
        font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, monospace;
        font-weight: 700;
        color: #dc2626;
        background: #fef2f2;
        padding: 3px 8px;
        border-radius: 6px;
        border: 1px solid #fee2e2;
        font-size: 11.5px;
        display: inline-block;
    }

    .badge-pill {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 9999px;
        font-size: 12px;
        font-weight: 600;
    }

    .badge-blue { background: #eff6ff; color: #1d4ed8; border: 1px solid #bfdbfe; }
    .badge-slate { background: #f1f5f9; color: #475569; border: 1px solid #e2e8f0; }
    .badge-emerald { background: #ecfdf5; color: #047857; border: 1px solid #a7f3d0; }

    /* Modal Backdrop & Dialog */
    .modal-backdrop-custom {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(15, 23, 42, 0.6);
        backdrop-filter: blur(4px);
        z-index: 9999;
        display: none;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .modal-backdrop-custom.show {
        display: flex;
    }

    .modal-dialog-custom {
        background: #ffffff;
        border-radius: 16px;
        max-width: 900px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);
        animation: modalFadeIn 0.2s ease-out;
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header-custom h3 {
        font-size: 17px;
        font-weight: 800;
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        background: #f8fafc;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        border-bottom-left-radius: 16px;
        border-bottom-right-radius: 16px;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: scale(0.97); }
        to { opacity: 1; transform: scale(1); }
    }
</style>
@endpush

@section('content')

<!-- Header Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-box-arrow-up-right"></i>
        </div>
        <div>
            <h1>Bukti Barang Keluar (Bon Keluar)</h1>
            <p>Pencatatan pengeluaran logistik material &amp; barang gudang berbasis arsitektur Master-Detail (Oracle 11g)</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div class="breadcrumb" style="font-size: 12.5px; color: #64748b;">
            <a href="{{ route('dashboard') }}" style="color: inherit; text-decoration: none;"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Transaksi</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Barang Keluar</span>
        </div>
        <button type="button" class="btn-custom btn-primary-custom" onclick="switchTab('create')">
            <i class="bi bi-plus-circle-fill"></i> Buat Bon Keluar Baru
        </button>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon red">
            <i class="bi bi-receipt-cutoff"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($totalTransaksi) }}</h3>
            <p>Total Bon Keluar</p>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon emerald">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($totalBarangKeluar, 2, ',', '.') }}</h3>
            <p>Total Barang Keluar (Unit)</p>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon blue">
            <i class="bi bi-briefcase-fill"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($totalProjectTerlayani) }}</h3>
            <p>Project Terlayani</p>
        </div>
    </div>

    <div class="kpi-card">
        <div class="kpi-icon amber">
            <i class="bi bi-calendar2-check-fill"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($transaksiBulanIni) }}</h3>
            <p>Transaksi Bulan Ini</p>
        </div>
    </div>
</div>

<!-- Tab Navigation Switcher -->
<div class="nav-tabs-custom">
    <button type="button" class="tab-btn {{ $activeTab === 'list' ? 'active' : '' }}" id="tabBtnList" onclick="switchTab('list')">
        <i class="bi bi-table"></i>
        <span>Daftar Bukti Barang Keluar</span>
        <span class="tab-badge">{{ $totalTransaksi }}</span>
    </button>
    <button type="button" class="tab-btn {{ $activeTab === 'create' ? 'active' : '' }}" id="tabBtnCreate" onclick="switchTab('create')">
        <i class="bi bi-file-earmark-plus-fill"></i>
        <span>Formulir Bukti Barang Keluar Baru</span>
        <span class="tab-badge" style="background: #dc2626; color: #fff;">+ New</span>
    </button>
</div>

<!-- ========================================================
     TAB 1: DAFTAR BUKTI BARANG KELUAR
     ======================================================== -->
<div id="tabContentList" style="{{ $activeTab === 'list' ? 'display: block;' : 'display: none;' }}">
    
    <!-- Filter Bar Card -->
    <div class="card-panel" style="margin-bottom: 20px;">
        <div class="card-panel-body" style="padding: 16px 20px;">
            <form action="{{ route('transaksi.barang-keluar') }}" method="GET" style="display: flex; gap: 12px; flex-wrap: wrap; align-items: center;">
                <input type="hidden" name="tab" value="list">
                
                <div style="flex: 1; min-width: 240px; position: relative;">
                    <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8;"></i>
                    <input type="text" name="q" class="form-control" style="padding-left: 36px;" 
                           placeholder="Cari No. Transaksi, Project, Subkon, Cutting Plan, atau Note..." 
                           value="{{ request('q') }}">
                </div>

                <div style="width: 170px;">
                    <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}" title="Tanggal Mulai">
                </div>

                <div style="width: 170px;">
                    <input type="date" name="tgl_akhir" class="form-control" value="{{ request('tgl_akhir') }}" title="Tanggal Akhir">
                </div>

                <button type="submit" class="btn-custom btn-primary-custom">
                    <i class="bi bi-filter"></i> Saring
                </button>

                @if(request()->anyFilled(['q', 'tgl_mulai', 'tgl_akhir', 'id_project']))
                <a href="{{ route('transaksi.barang-keluar', ['tab' => 'list']) }}" class="btn-custom btn-secondary-custom">
                    <i class="bi bi-x-circle"></i> Reset
                </a>
                @endif
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card-panel">
        <div class="card-panel-header">
            <span><i class="bi bi-database-fill-check text-danger"></i> Data Bon Keluar (Oracle: <code>GD_BON_KELUAR_M</code>)</span>
            <span style="font-size: 12px; color: #64748b; font-weight: 500;">
                Menampilkan {{ $transaksiList->firstItem() ?? 0 }} - {{ $transaksiList->lastItem() ?? 0 }} dari {{ $transaksiList->total() }} transaksi
            </span>
        </div>
        <div class="card-panel-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 160px;">No. Transaksi</th>
                            <th style="width: 110px;">Tanggal</th>
                            <th>Untuk Project / No. IKI</th>
                            <th style="width: 160px;">Sub-Contractor</th>
                            <th style="text-align: center; width: 90px;">Jml Item</th>
                            <th style="text-align: right; width: 130px;">Total Qty Keluar</th>
                            <th style="width: 130px;">Input By</th>
                            <th style="width: 120px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($transaksiList as $index => $trx)
                        <tr>
                            <td style="text-align: center; color: #64748b;">
                                {{ $transaksiList->firstItem() + $index }}
                            </td>
                            <td>
                                <strong style="color: #dc2626; font-weight: 800; font-family: ui-monospace, monospace;">
                                    {{ $trx->no_transaksi }}
                                </strong>
                                <div style="font-size: 11px; color: #94a3b8;">ID Oracle: {{ $trx->id_transaksi }}</div>
                                @if($trx->no_cutting)
                                    <div style="font-size: 11px; color: #475569; margin-top: 2px;">
                                        <i class="bi bi-scissors"></i> Cut: {{ $trx->no_cutting }}
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ $trx->tgl_transaksi ? \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                @if($trx->project)
                                    <div>
                                        <span class="badge-pill badge-blue" style="font-size: 11px; padding: 2px 8px;">
                                            <i class="bi bi-briefcase"></i> {{ $trx->project->kd_project }}
                                        </span>
                                    </div>
                                    <div style="font-weight: 600; font-size: 12.5px; color: #0f172a; margin-top: 3px;">
                                        {{ $trx->project->nm_project }}
                                    </div>
                                @else
                                    <span style="color: #94a3b8; font-style: italic;">Umum / Non-Project</span>
                                @endif
                            </td>
                            <td>
                                <div style="font-weight: 600; color: #1e293b;">
                                    {{ $trx->subkon_pakai ?: '-' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-status info">
                                    <i class="bi bi-box-seam"></i> {{ $trx->details->count() }} item
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                {{ number_format($trx->total_kuantitas, 2, ',', '.') }}
                            </td>
                            <td>
                                <div style="font-size: 12px; font-weight: 600;">{{ $trx->opr_insert ?? 'ADMIN' }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">
                                    {{ $trx->tgl_insert ? \Carbon\Carbon::parse($trx->tgl_insert)->format('d/m/y H:i') : '-' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn-sm-action detail" title="Lihat Rincian Detail" onclick="lihatDetailTransaksi({{ $trx->id_transaksi }})">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <a href="{{ route('transaksi.barang-keluar.cetak', $trx->id_transaksi) }}" target="_blank" class="btn-sm-action print" title="Cetak Bukti Barang Keluar">
                                        <i class="bi bi-printer-fill"></i>
                                    </a>
                                    <button type="button" class="btn-sm-action delete" title="Batalkan & Hapus Transaksi" onclick="hapusTransaksi({{ $trx->id_transaksi }}, '{{ $trx->no_transaksi }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" style="text-align: center; padding: 48px; color: #94a3b8;">
                                <i class="bi bi-inbox fs-1" style="display: block; margin-bottom: 8px;"></i>
                                <p style="font-weight: 600; font-size: 14px; color: #64748b;">Belum ada data bukti barang keluar yang tercatat.</p>
                                <button type="button" class="btn-custom btn-primary-custom" style="margin-top: 10px;" onclick="switchTab('create')">
                                    <i class="bi bi-plus-circle"></i> Buat Bon Keluar Sekarang
                                </button>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if($transaksiList->hasPages())
            <div style="padding: 16px 20px; border-top: 1px solid #e2e8f0; display: flex; justify-content: space-between; align-items: center;">
                <div style="font-size: 13px; color: #64748b;">
                    Total Data: <strong>{{ $transaksiList->total() }}</strong> Transaksi
                </div>
                <div>
                    {{ $transaksiList->links() }}
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

<!-- ========================================================
     TAB 2: FORMULIR INPUT BUKTI BARANG KELUAR (DELPHI STYLE)
     ======================================================== -->
<div id="tabContentCreate" style="{{ $activeTab === 'create' ? 'display: block;' : 'display: none;' }}">
    
    <form id="formBonKeluar" onsubmit="event.preventDefault(); simpanTransaksiKeOracle();">
        @csrf

        <!-- CARD 1: DELPHI STYLE HEADER PANEL -->
        <div class="delphi-header-card">
            
            <div class="delphi-top-bar">
                <div class="delphi-title">
                    <i class="bi bi-file-earmark-arrow-up-fill text-danger"></i>
                    <span>Bukti Barang Keluar</span>
                </div>
                <div style="display: flex; align-items: center; gap: 14px;">
                    <span class="valid-stamp"><i class="bi bi-check2-circle"></i> VALID</span>
                    <span class="delphi-trx-badge" id="previewNoTransaksiText">{{ $noTransaksiPreview }}</span>
                    <input type="hidden" id="inputNoTransaksi" name="no_transaksi" value="{{ $noTransaksiPreview }}">
                </div>
            </div>

            <div class="delphi-grid">
                
                <!-- KOLOM KIRI: Project & Subkon -->
                <div>
                    <div class="form-group-custom">
                        <label>
                            Untuk Project / No IKI :
                            <span class="text-muted" style="font-size: 10.5px; text-transform: none; font-weight: 500;">(Pilih / Cari Proyek)</span>
                        </label>
                        <div style="display: flex; gap: 6px;">
                            <select class="form-select" id="selectProject" name="id_project_pakai" onchange="onProjectChange(this.value)">
                                <option value="">-- Non Project / Pemakaian Umum --</option>
                                @foreach($projects as $p)
                                    <option value="{{ $p->id_project }}" data-kode="{{ $p->kd_project }}" data-nama="{{ $p->nm_project }}">
                                        {{ $p->kd_project }} - {{ \Illuminate\Support\Str::limit($p->nm_project, 40) }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="button" class="btn-custom btn-secondary-custom" title="Buka Pencarian Seluruh Proyek (700+ Data)" onclick="bukaModalProjectPicker()" style="padding: 0 12px;">
                                <i class="bi bi-three-dots"></i>
                            </button>
                        </div>
                        <div id="projectNameDisplay" style="margin-top: 6px; font-size: 12px; color: #2563eb; font-weight: 600; min-height: 18px;">
                            Name : <span id="lblProjectName" style="color: #475569; font-weight: normal;">-</span>
                        </div>
                    </div>

                    <div class="form-group-custom">
                        <label>Sub-Contractor :</label>
                        <input type="text" class="form-control" id="inputSubkon" name="subkon_pakai" placeholder="Contoh: IMAM PAINTING / CV. LOGISTIK">
                    </div>
                </div>

                <!-- KOLOM TENGAH: Validasi & Cutting Plan -->
                <div>
                    <div class="form-group-custom">
                        <label>No. Cutting Plan :</label>
                        <input type="text" class="form-control" id="inputCuttingPlan" name="no_cutting" placeholder="Nomor Rencana Potong">
                    </div>

                    <div class="form-group-custom">
                        <label>Bagian / Divisi :</label>
                        <select class="form-select" id="selectBagian" name="id_divisi_group">
                            @foreach($bagianList as $bg)
                                <option value="{{ $bg }}" {{ $bg === 'GUDANG' ? 'selected' : '' }}>{{ $bg }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- KOLOM KANAN: Tanggal & Transaksi No -->
                <div>
                    <div class="form-group-custom">
                        <label>Tanggal <span class="required">*</span> :</label>
                        <input type="text" class="form-control" id="inputTanggal" name="tgl_transaksi" value="{{ $tglTransaksi }}" required>
                        <small style="font-size: 11px; color: #64748b;">Format: DD/MM/YYYY</small>
                    </div>

                    <div class="form-group-custom">
                        <label>Transaksi No. :</label>
                        <div style="display: flex; gap: 6px;">
                            <input type="text" class="form-control" style="width: 80px; font-weight: 700; background: #f8fafc;" value="BKT" readonly>
                            <span style="align-self: center; font-weight: 700; color: #94a3b8;">-</span>
                            <input type="number" class="form-control" id="inputCounter" name="counter" value="{{ $nextCounter }}" oninput="updatePreviewNoTransaksi()">
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- CARD 2: MASTER-DETAIL ITEM GRID (FREE INPUT) -->
        <div class="card-panel">
            <div class="card-panel-header" style="background: #ffffff; border-bottom: 2px solid #e2e8f0;">
                <div style="display: flex; align-items: center; gap: 10px;">
                    <i class="bi bi-grid-3x3-gap-fill text-danger"></i>
                    <span>Rincian Item Barang Keluar (Bebas / Free Input dari Master Data)</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <button type="button" class="btn-custom btn-primary-custom" onclick="bukaModalItemPicker()" style="padding: 7px 14px; font-size: 12.5px;">
                        <i class="bi bi-box-seam"></i> Pilih Item dari Master (Multi-Select)
                    </button>
                    <button type="button" class="btn-custom btn-secondary-custom" onclick="tambahBarisBarangManual()" style="padding: 7px 14px; font-size: 12.5px;">
                        <i class="bi bi-plus-lg"></i> + Tambah Baris
                    </button>
                </div>
            </div>

            <div class="card-panel-body" style="padding: 0;">
                <div class="table-responsive">
                    <table class="data-table" id="tableBarangKeluarDetail">
                        <thead>
                            <tr>
                                <th style="width: 40px; text-align: center;">No.</th>
                                <th style="width: 220px;">Kode &amp; Nama Barang <span class="required">*</span></th>
                                <th style="width: 90px;">Panjang</th>
                                <th style="width: 130px;">Spesifikasi</th>
                                <th style="width: 100px; text-align: right;">Jumlah <span class="required">*</span></th>
                                <th style="width: 100px;">Satuan <span class="required">*</span></th>
                                <th style="width: 130px;">Asal Stok</th>
                                <th style="width: 130px;">No. IKI</th>
                                <th style="width: 110px;">Heat No</th>
                                <th>Keterangan</th>
                                <th style="width: 50px; text-align: center;">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyDetailBarang">
                            <!-- Dynamic Rows will be inserted here -->
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8fafc; font-weight: 800; border-top: 2px solid #cbd5e1;">
                                <td colspan="4" style="text-align: right; color: #475569;">TOTAL KUANTITAS DIKELUARKAN:</td>
                                <td style="text-align: right; color: #dc2626; font-size: 14px;" id="grandTotalQtyDisplay">0.00</td>
                                <td colspan="6"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <!-- CARD 3: NOTE & FORM ACTION BUTTONS -->
        <div class="card-panel" style="margin-bottom: 24px;">
            <div class="card-panel-body">
                <div class="form-group-custom" style="margin-bottom: 0;">
                    <label>Note / Catatan Tambahan :</label>
                    <textarea class="form-control" id="inputNote" name="keterangan" rows="3" 
                              placeholder="Contoh: 556/2026 - CAT &amp; THINNER"></textarea>
                </div>
            </div>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 40px;">
            <button type="button" class="btn-custom btn-secondary-custom" onclick="switchTab('list')">
                <i class="bi bi-x-circle"></i> Batal
            </button>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="resetFormBonKeluar()">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Isian
            </button>
            <button type="submit" id="btnSubmitBonKeluar" class="btn-custom btn-success-custom" style="padding: 10px 24px; font-size: 14px;">
                <i class="bi bi-save2-fill"></i> Simpan ke Oracle Database
            </button>
        </div>

    </form>

</div>

<!-- ========================================================
     MODAL DETAIL TRANSAKSI POPUP (VIEW RINCIAN)
     ======================================================== -->
<div class="modal-backdrop-custom" id="modalDetail">
    <div class="modal-dialog-custom">
        <div class="modal-header-custom">
            <div>
                <h3 id="modalDetailTitle">Rincian Bukti Barang Keluar</h3>
                <span style="font-size: 12px; color: #64748b;" id="modalDetailSubtitle">-</span>
            </div>
            <button type="button" class="btn-sm-action" onclick="tutupModalDetail()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-custom">
            <!-- Header Metadata Info -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 16px; margin-bottom: 20px;">
                <div>
                    <div style="font-size: 11px; color: #64748b; font-weight: 600;">PROJECT / NO IKI:</div>
                    <strong style="font-size: 14px; color: #dc2626;" id="modalKdProject">-</strong>
                    <div style="font-size: 12px; color: #475569;" id="modalNmProject">-</div>
                    <div style="font-size: 12px; color: #64748b; margin-top: 6px;">
                        Sub-Contractor: <strong id="modalSubkon" style="color: #0f172a;">-</strong>
                    </div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748b; font-size: 12px;">Tanggal Transaksi:</span>
                        <strong id="modalTgl">-</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748b; font-size: 12px;">No. Cutting Plan:</span>
                        <strong id="modalCutting">-</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748b; font-size: 12px;">Petugas Input:</span>
                        <span id="modalOperator">-</span>
                    </div>
                </div>
            </div>

            <!-- Detail Barang Table -->
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">No</th>
                            <th style="width: 120px;">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style="width: 100px; text-align: right;">Jumlah</th>
                            <th style="width: 90px; text-align: center;">Satuan</th>
                            <th style="width: 110px;">Asal Stok</th>
                            <th style="width: 110px;">No. IKI</th>
                            <th style="width: 100px;">Heat No</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody id="modalTbodyBarang">
                        <!-- Loaded dynamically -->
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8fafc; font-weight: 800; border-top: 2px solid #cbd5e1;">
                            <td colspan="3" style="text-align: right;">TOTAL KUANTITAS:</td>
                            <td style="text-align: right; color: #dc2626;" id="modalTotalQty">0.00</td>
                            <td colspan="5"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div style="margin-top: 16px; padding: 12px; background: #fffbeb; border: 1px solid #fef3c7; border-radius: 8px; font-size: 12.5px;">
                <strong>Note / Catatan:</strong> <span id="modalNoteText">-</span>
            </div>
        </div>
        <div class="modal-footer-custom">
            <a href="#" id="modalBtnCetak" target="_blank" class="btn-custom btn-primary-custom">
                <i class="bi bi-printer"></i> Cetak Bukti Barang Keluar
            </a>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="tutupModalDetail()">
                Tutup
            </button>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL MULTI-SELECT ITEM PICKER (DARI MASTER BARANG)
     ======================================================== -->
<div class="modal-backdrop-custom" id="modalItemPicker">
    <div class="modal-dialog-custom" style="max-width: 800px;">
        <div class="modal-header-custom">
            <div>
                <h3 style="font-size: 16px;"><i class="bi bi-boxes text-primary"></i> Pilih Item dari Master Barang</h3>
                <span style="font-size: 12px; color: #64748b;">Centang satu atau beberapa barang untuk ditambahkan ke grid dokumen</span>
            </div>
            <button type="button" class="btn-sm-action" onclick="tutupModalItemPicker()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-custom" style="padding-bottom: 10px;">
            <div style="margin-bottom: 14px; position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8;"></i>
                <input type="text" id="filterModalItemInput" class="form-control" style="padding-left: 36px;" 
                       placeholder="Cari kode atau nama barang..." onkeyup="filterItemPickerModal()">
            </div>
            <div style="max-height: 400px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
                <table class="data-table" id="tableModalItemPicker">
                    <thead style="position: sticky; top: 0; z-index: 2;">
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="checkAllItems" onchange="toggleSelectAllModalItems(this.checked)">
                            </th>
                            <th style="width: 140px;">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style="width: 100px; text-align: center;">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($items as $it)
                        <tr class="modal-item-row" data-id="{{ $it->id_barang }}" data-kode="{{ $it->kode_barang }}" data-nama="{{ $it->nama_barang }}" data-satuan-id="{{ $it->id_satuan }}" data-satuan="{{ $it->satuan?->nama_satuan ?? '-' }}">
                            <td style="text-align: center;">
                                <input type="checkbox" class="chk-item-modal" value="{{ $it->id_barang }}">
                            </td>
                            <td><strong style="color: #dc2626;">{{ $it->kode_barang }}</strong></td>
                            <td>{{ $it->nama_barang }}</td>
                            <td style="text-align: center;"><span class="badge-pill badge-blue">{{ $it->satuan?->nama_satuan ?? '-' }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer-custom">
            <span style="margin-right: auto; font-size: 12px; color: #64748b;" id="countSelectedItemsText">0 item terpilih</span>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="tutupModalItemPicker()">Batal</button>
            <button type="button" class="btn-custom btn-primary-custom" onclick="tambahkanItemTerpilihKeGrid()">
                <i class="bi bi-plus-circle"></i> Tambahkan ke Dokumen
            </button>
        </div>
    </div>
</div>

<!-- ========================================================
     MODAL PROJECT IKI LOOKUP (CARI DARI 721 PROYEK)
     ======================================================== -->
<div class="modal-backdrop-custom" id="modalProjectPicker">
    <div class="modal-dialog-custom" style="max-width: 800px;">
        <div class="modal-header-custom">
            <div>
                <h3 style="font-size: 16px;"><i class="bi bi-briefcase text-primary"></i> Cari Data Project / No. IKI (Oracle Database)</h3>
                <span style="font-size: 12px; color: #64748b;">Pencarian realtime pada tabel <code>M_PROJECT_IKI</code></span>
            </div>
            <button type="button" class="btn-sm-action" onclick="tutupModalProjectPicker()">
                <i class="bi bi-x-lg"></i>
            </button>
        </div>
        <div class="modal-body-custom">
            <div style="margin-bottom: 14px; position: relative;">
                <i class="bi bi-search" style="position: absolute; left: 12px; top: 10px; color: #94a3b8;"></i>
                <input type="text" id="searchProjectLiveInput" class="form-control" style="padding-left: 36px;" 
                       placeholder="Ketik kode proyek atau nama pekerjaan..." onkeyup="liveSearchProject(this.value)">
            </div>
            <div style="max-height: 380px; overflow-y: auto; border: 1px solid #e2e8f0; border-radius: 8px;">
                <table class="data-table" id="tableModalProjectList">
                    <thead style="position: sticky; top: 0; z-index: 2;">
                        <tr>
                            <th style="width: 170px;">Kode Project / IKI</th>
                            <th>Nama Project</th>
                            <th style="width: 100px; text-align: center;">Pilih</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyModalProjectList">
                        @foreach($projects->take(30) as $pj)
                        <tr>
                            <td><strong style="color: #2563eb;">{{ $pj->kd_project }}</strong></td>
                            <td>{{ $pj->nm_project }}</td>
                            <td style="text-align: center;">
                                <button type="button" class="btn-custom btn-secondary-custom" style="padding: 4px 10px; font-size: 11px;"
                                        onclick="pilihProjectDariModal({{ $pj->id_project }}, '{{ addslashes($pj->kd_project) }}', '{{ addslashes($pj->nm_project) }}')">
                                    Pilih
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="modal-footer-custom">
            <button type="button" class="btn-custom btn-secondary-custom" onclick="tutupModalProjectPicker()">Tutup</button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Data Master Cache di JavaScript
    const masterItems = @json($items);
    const masterSatuans = @json($satuans);
    const masterAsalStok = @json($asalStokList);

    // Tab Switching Functionality
    function switchTab(tabName) {
        const tabList = document.getElementById('tabContentList');
        const tabCreate = document.getElementById('tabContentCreate');
        const btnList = document.getElementById('tabBtnList');
        const btnCreate = document.getElementById('tabBtnCreate');

        if (tabName === 'create') {
            tabList.style.display = 'none';
            tabCreate.style.display = 'block';
            btnList.classList.remove('active');
            btnCreate.classList.add('active');
            
            // Jika grid masih kosong, tambahkan baris default pertama
            if (document.querySelectorAll('#tbodyDetailBarang tr').length === 0) {
                tambahBarisBarangManual();
            }
        } else {
            tabList.style.display = 'block';
            tabCreate.style.display = 'none';
            btnList.classList.add('active');
            btnCreate.classList.remove('active');
        }
    }

    // Handler Perubahan Project pada Header
    function onProjectChange(idProject) {
        const select = document.getElementById('selectProject');
        const selectedOpt = select.options[select.selectedIndex];
        const lblName = document.getElementById('lblProjectName');

        if (idProject && selectedOpt) {
            const nama = selectedOpt.getAttribute('data-nama') || '-';
            const kode = selectedOpt.getAttribute('data-kode') || '';
            lblName.innerText = nama;

            // Update default Note jika masih kosong
            const inputNote = document.getElementById('inputNote');
            if (!inputNote.value.trim() && kode) {
                inputNote.value = `${kode} - `;
            }

            // Sync kolom "No. IKI" pada setiap baris grid yang masih kosong
            document.querySelectorAll('#tbodyDetailBarang .row-no-iki').forEach(input => {
                if (!input.value.trim()) {
                    input.value = kode;
                }
            });
        } else {
            lblName.innerText = '-';
        }
    }

    // Update Preview No. Transaksi saat Counter diedit
    function updatePreviewNoTransaksi() {
        const counter = document.getElementById('inputCounter').value || '5337';
        const roman = "{{ $romanMonth ?? 'XI' }}";
        const year = "{{ $year ?? Carbon\Carbon::now()->year }}";
        const formatted = `${counter}/BKT/${roman}/${year}`;
        document.getElementById('previewNoTransaksiText').innerText = formatted;
        document.getElementById('inputNoTransaksi').value = formatted;
    }

    // Tambah Baris Manual ke Grid Barang Keluar
    function tambahBarisBarangManual(preselectedItem = null) {
        const tbody = document.getElementById('tbodyDetailBarang');
        const rowIdx = tbody.children.length;
        const currentProjectKode = document.getElementById('selectProject')?.options[document.getElementById('selectProject').selectedIndex]?.getAttribute('data-kode') || '';

        const tr = document.createElement('tr');
        tr.className = 'item-row';

        // Buat opsi dropdown master barang
        let itemOptions = '<option value="">-- Pilih Barang --</option>';
        masterItems.forEach(it => {
            const selected = (preselectedItem && preselectedItem.id_barang == it.id_barang) ? 'selected' : '';
            itemOptions += `<option value="${it.id_barang}" data-kode="${it.kode_barang}" data-nama="${it.nama_barang}" data-satuan-id="${it.id_satuan}" ${selected}>${it.kode_barang} - ${it.nama_barang}</option>`;
        });

        // Buat opsi satuan
        let satuanOptions = '';
        masterSatuans.forEach(s => {
            const selected = (preselectedItem && preselectedItem.id_satuan == s.id) ? 'selected' : '';
            satuanOptions += `<option value="${s.id}" ${selected}>${s.nama_satuan}</option>`;
        });

        // Buat opsi asal stok
        let asalStokOptions = '';
        masterAsalStok.forEach(a => {
            asalStokOptions += `<option value="${a}">${a}</option>`;
        });

        tr.innerHTML = `
            <td style="text-align: center; color: #64748b; font-weight: 600;" class="row-num">${rowIdx + 1}</td>
            <td>
                <select class="form-select select-item" name="items[${rowIdx}][id_barang]" required onchange="onItemRowChange(this)">
                    ${itemOptions}
                </select>
            </td>
            <td>
                <input type="text" class="form-control" name="items[${rowIdx}][panjang]" placeholder="Pjg">
            </td>
            <td>
                <input type="text" class="form-control" name="items[${rowIdx}][spesifikasi]" placeholder="Spesifikasi">
            </td>
            <td>
                <input type="number" step="0.01" min="0.01" class="form-control row-qty" name="items[${rowIdx}][jumlah]" 
                       value="${preselectedItem?.jumlah || 1}" required style="text-align: right; font-weight: 700; color: #dc2626;" oninput="hitungGrandTotalQty()">
            </td>
            <td>
                <select class="form-select select-satuan" name="items[${rowIdx}][id_satuan]" required>
                    ${satuanOptions}
                </select>
            </td>
            <td>
                <select class="form-select" name="items[${rowIdx}][asal_stok]">
                    ${asalStokOptions}
                </select>
            </td>
            <td>
                <input type="text" class="form-control row-no-iki" name="items[${rowIdx}][no_iki]" value="${currentProjectKode}" placeholder="No. IKI">
            </td>
            <td>
                <input type="text" class="form-control" name="items[${rowIdx}][heat_no]" placeholder="Heat No">
            </td>
            <td>
                <input type="text" class="form-control" name="items[${rowIdx}][keterangan]" placeholder="Catatan item">
            </td>
            <td style="text-align: center;">
                <button type="button" class="btn-sm-action delete" title="Hapus Baris" onclick="hapusBarisBarang(this)">
                    <i class="bi bi-trash-fill"></i>
                </button>
            </td>
        `;

        tbody.appendChild(tr);
        hitungGrandTotalQty();
    }

    // Handler saat barang dipilih pada baris
    function onItemRowChange(selectElem) {
        const tr = selectElem.closest('tr');
        const selectedOpt = selectElem.options[selectElem.selectedIndex];
        const satuanId = selectedOpt.getAttribute('data-satuan-id');

        if (satuanId) {
            const satuanSelect = tr.querySelector('.select-satuan');
            if (satuanSelect) {
                satuanSelect.value = satuanId;
            }
        }
    }

    // Hapus Baris Barang
    function hapusBarisBarang(btn) {
        const tbody = document.getElementById('tbodyDetailBarang');
        if (tbody.children.length <= 1) {
            alert('Minimal 1 baris item barang harus ada pada dokumen pengeluaran.');
            return;
        }
        btn.closest('tr').remove();
        
        // Re-index nomor baris
        tbody.querySelectorAll('.row-num').forEach((cell, idx) => {
            cell.innerText = idx + 1;
        });

        hitungGrandTotalQty();
    }

    // Hitung Grand Total Kuantitas Barang Keluar
    function hitungGrandTotalQty() {
        let total = 0;
        document.querySelectorAll('#tbodyDetailBarang .row-qty').forEach(input => {
            total += parseFloat(input.value) || 0;
        });
        document.getElementById('grandTotalQtyDisplay').innerText = total.toFixed(2);
    }

    // Reset Form Bon Keluar
    function resetFormBonKeluar() {
        if (confirm('Bersihkan seluruh isian form Bukti Barang Keluar?')) {
            document.getElementById('selectProject').value = '';
            document.getElementById('lblProjectName').innerText = '-';
            document.getElementById('inputSubkon').value = '';
            document.getElementById('inputCuttingPlan').value = '';
            document.getElementById('inputNote').value = '';
            document.getElementById('tbodyDetailBarang').innerHTML = '';
            tambahBarisBarangManual();
            hitungGrandTotalQty();
        }
    }

    // SIMPAN TRANSAKSI KE DATABASE ORACLE (AJAX POST)
    function simpanTransaksiKeOracle() {
        const tglTransaksi = document.getElementById('inputTanggal').value;
        const noTransaksi = document.getElementById('inputNoTransaksi').value;
        const idProject = document.getElementById('selectProject').value;
        const subkon = document.getElementById('inputSubkon').value;
        const cutting = document.getElementById('inputCuttingPlan').value;
        const bagian = document.getElementById('selectBagian').value;
        const counter = document.getElementById('inputCounter').value;
        const note = document.getElementById('inputNote').value;

        // Validasi Baris Barang
        const rows = document.querySelectorAll('#tbodyDetailBarang tr.item-row');
        if (rows.length === 0) {
            alert('⚠️ Minimal harus ada 1 item barang yang dikeluarkan.');
            return;
        }

        const items = [];
        let hasInvalidItem = false;

        rows.forEach((row, idx) => {
            const idBarang = row.querySelector('.select-item')?.value;
            const jumlah = parseFloat(row.querySelector('.row-qty')?.value) || 0;
            const idSatuan = row.querySelector('.select-satuan')?.value;
            const asalStok = row.querySelector('select[name*="[asal_stok]"]')?.value || 'Stok Project';
            const heatNo = row.querySelector('input[name*="[heat_no]"]')?.value || '';
            const noIki = row.querySelector('.row-no-iki')?.value || '';
            const keterangan = row.querySelector('input[name*="[keterangan]"]')?.value || '';

            if (!idBarang) {
                hasInvalidItem = true;
                row.querySelector('.select-item').focus();
            }

            items.push({
                id_barang: idBarang,
                jumlah: jumlah,
                id_satuan: idSatuan,
                asal_stok: asalStok,
                heat_no: heatNo,
                no_iki: noIki,
                keterangan: keterangan,
            });
        });

        if (hasInvalidItem) {
            alert('⚠️ Harap pilih barang pada semua baris yang terdaftar.');
            return;
        }

        const submitBtn = document.getElementById('btnSubmitBonKeluar');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-arrow-repeat spin"></i> Menyimpan ke Oracle...';

        const payload = {
            tgl_transaksi: tglTransaksi,
            no_transaksi: noTransaksi,
            id_project_pakai: idProject,
            subkon_pakai: subkon,
            no_cutting: cutting,
            bagian: bagian,
            counter: counter,
            keterangan: note,
            items: items
        };

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch("{{ route('transaksi.barang-keluar.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(res => res.json())
        .then(res => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan ke Oracle Database';

            if (res.success) {
                alert('✅ ' + res.message);
                window.location.href = "{{ route('transaksi.barang-keluar') }}?tab=list";
            } else {
                alert('❌ Gagal: ' + (res.message || 'Terjadi kesalahan sistem.'));
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan ke Oracle Database';
            alert('❌ Kesalahan jaringan/server: ' + err.message);
        });
    }

    // Modal Item Picker (Multi-Select) Logic
    function bukaModalItemPicker() {
        document.getElementById('checkAllItems').checked = false;
        document.querySelectorAll('.chk-item-modal').forEach(c => c.checked = false);
        document.getElementById('filterModalItemInput').value = '';
        filterItemPickerModal();
        updateSelectedItemsCount();
        document.getElementById('modalItemPicker').classList.add('show');
    }

    function tutupModalItemPicker() {
        document.getElementById('modalItemPicker').classList.remove('show');
    }

    function filterItemPickerModal() {
        const query = document.getElementById('filterModalItemInput').value.toLowerCase();
        document.querySelectorAll('#tableModalItemPicker tbody tr').forEach(row => {
            row.style.display = row.innerText.toLowerCase().includes(query) ? '' : 'none';
        });
    }

    function toggleSelectAllModalItems(checked) {
        document.querySelectorAll('#tableModalItemPicker tbody tr:not([style*="display: none"]) .chk-item-modal').forEach(chk => {
            chk.checked = checked;
        });
        updateSelectedItemsCount();
    }

    function updateSelectedItemsCount() {
        const count = document.querySelectorAll('.chk-item-modal:checked').length;
        document.getElementById('countSelectedItemsText').innerText = `${count} item terpilih`;
    }

    document.addEventListener('change', function(e) {
        if (e.target.classList.contains('chk-item-modal')) {
            updateSelectedItemsCount();
        }
    });

    function tambahkanItemTerpilihKeGrid() {
        const checkedBoxes = document.querySelectorAll('.chk-item-modal:checked');
        if (checkedBoxes.length === 0) {
            alert('Silakan centang minimal 1 item terlebih dahulu.');
            return;
        }

        // Hapus baris kosong pertama jika belum diisi barang
        const firstRowSelect = document.querySelector('#tbodyDetailBarang tr.item-row:first-child .select-item');
        if (firstRowSelect && !firstRowSelect.value) {
            document.querySelector('#tbodyDetailBarang tr.item-row:first-child').remove();
        }

        checkedBoxes.forEach(chk => {
            const tr = chk.closest('tr');
            const idBarang = tr.getAttribute('data-id');
            const idSatuan = tr.getAttribute('data-satuan-id');
            tambahBarisBarangManual({
                id_barang: idBarang,
                id_satuan: idSatuan,
                jumlah: 1
            });
        });

        tutupModalItemPicker();
    }

    // Modal Project Picker Logic
    function bukaModalProjectPicker() {
        document.getElementById('searchProjectLiveInput').value = '';
        document.getElementById('modalProjectPicker').classList.add('show');
    }

    function tutupModalProjectPicker() {
        document.getElementById('modalProjectPicker').classList.remove('show');
    }

    function pilihProjectDariModal(idProject, kdProject, nmProject) {
        const select = document.getElementById('selectProject');
        
        // Cek apakah opsi sudah ada di select, jika tidak tambahkan secara dinamis
        let opt = select.querySelector(`option[value="${idProject}"]`);
        if (!opt) {
            opt = document.createElement('option');
            opt.value = idProject;
            opt.setAttribute('data-kode', kdProject);
            opt.setAttribute('data-nama', nmProject);
            opt.innerText = `${kdProject} - ${nmProject}`;
            select.appendChild(opt);
        }

        select.value = idProject;
        onProjectChange(idProject);
        tutupModalProjectPicker();
    }

    function liveSearchProject(query) {
        if (query.length < 2) return;
        fetch(`{{ route('transaksi.barang-keluar.projects') }}?q=${encodeURIComponent(query)}`)
            .then(res => res.json())
            .then(data => {
                const tbody = document.getElementById('tbodyModalProjectList');
                tbody.innerHTML = '';
                if (data.length === 0) {
                    tbody.innerHTML = '<tr><td colspan="3" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada proyek ditemukan.</td></tr>';
                    return;
                }
                data.forEach(p => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td><strong style="color: #2563eb;">${p.kd_project}</strong></td>
                        <td>${p.nm_project}</td>
                        <td style="text-align: center;">
                            <button type="button" class="btn-custom btn-secondary-custom" style="padding: 4px 10px; font-size: 11px;"
                                    onclick="pilihProjectDariModal(${p.id_project}, '${p.kd_project.replace(/'/g, "\\'")}', '${p.nm_project.replace(/'/g, "\\'")}')">
                                Pilih
                            </button>
                        </td>
                    `;
                    tbody.appendChild(tr);
                });
            });
    }

    // LIHAT DETAIL TRANSAKSI (POPUP MODAL)
    function lihatDetailTransaksi(idTransaksi) {
        fetch(`{{ url('transaksi/barang-keluar') }}/${idTransaksi}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const data = res.data;
                document.getElementById('modalDetailTitle').innerText = `Bukti Barang Keluar: ${data.no_transaksi}`;
                document.getElementById('modalDetailSubtitle').innerText = `ID Transaksi Oracle: ${data.id_transaksi} • Tgl Input: ${data.tgl_insert}`;
                
                document.getElementById('modalKdProject').innerText = data.project?.kd_project || '-';
                document.getElementById('modalNmProject').innerText = data.project?.nm_project || 'Umum / Non-Project';
                document.getElementById('modalSubkon').innerText = data.subkon_pakai || '-';
                document.getElementById('modalTgl').innerText = data.tgl_transaksi || '-';
                document.getElementById('modalCutting').innerText = data.no_cutting || '-';
                document.getElementById('modalOperator').innerText = data.opr_insert || '-';
                document.getElementById('modalNoteText').innerText = data.keterangan || '-';

                const tbody = document.getElementById('modalTbodyBarang');
                tbody.innerHTML = '';

                if (data.items && data.items.length > 0) {
                    data.items.forEach(item => {
                        const tr = document.createElement('tr');
                        tr.innerHTML = `
                            <td style="text-align: center; color: #64748b;">${item.no_urut}</td>
                            <td><strong style="color: #dc2626;">${item.kode_barang}</strong></td>
                            <td>${item.nama_barang}</td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">${Number(item.jumlah).toFixed(2)}</td>
                            <td style="text-align: center;">${item.satuan}</td>
                            <td>${item.asal_stok || 'Stok Project'}</td>
                            <td>${item.no_iki || '-'}</td>
                            <td>${item.heat_no || '-'}</td>
                            <td>${item.keterangan || '-'}</td>
                        `;
                        tbody.appendChild(tr);
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="9" style="text-align: center; color: #94a3b8; padding: 20px;">Tidak ada rincian barang.</td></tr>';
                }

                document.getElementById('modalTotalQty').innerText = Number(data.total_kuantitas || 0).toFixed(2);
                document.getElementById('modalBtnCetak').href = `{{ url('transaksi/barang-keluar') }}/${data.id_transaksi}/cetak`;

                document.getElementById('modalDetail').classList.add('show');
            } else {
                alert('Gagal mengambil rincian data.');
            }
        })
        .catch(err => {
            alert('Kesalahan saat memuat detail: ' + err.message);
        });
    }

    function tutupModalDetail() {
        document.getElementById('modalDetail').classList.remove('show');
    }

    // HAPUS / BATALKAN TRANSAKSI
    function hapusTransaksi(idTransaksi, noTransaksi) {
        if (!confirm(`Apakah Anda yakin ingin membatalkan & menghapus Bukti Barang Keluar [${noTransaksi}] dari Oracle Database?`)) {
            return;
        }

        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';

        fetch(`{{ url('transaksi/barang-keluar') }}/${idTransaksi}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': csrfToken,
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                alert('✅ ' + res.message);
                window.location.reload();
            } else {
                alert('❌ Gagal: ' + (res.message || 'Tidak dapat menghapus transaksi.'));
            }
        })
        .catch(err => {
            alert('Kesalahan saat menghapus transaksi: ' + err.message);
        });
    }

    // Klik Backdrop Luar Modal untuk Menutup
    window.addEventListener('click', function(e) {
        ['modalDetail', 'modalItemPicker', 'modalProjectPicker'].forEach(id => {
            const modal = document.getElementById(id);
            if (modal && e.target === modal) {
                modal.classList.remove('show');
            }
        });
    });
</script>
@endpush

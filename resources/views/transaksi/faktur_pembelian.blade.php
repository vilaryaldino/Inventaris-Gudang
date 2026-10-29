@extends('layouts.app')

@section('title', 'Penerimaan Pembelian & Faktur')

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
        background: linear-gradient(135deg, #2563eb, #1d4ed8);
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 24px;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.25);
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
        grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
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
        color: #2563eb;
        border-color: #bfdbfe;
        background: #eff6ff;
        transform: translateY(-1px);
    }

    .tab-btn.active {
        color: #ffffff;
        background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
        border-color: #1d4ed8;
        font-weight: 700;
        box-shadow: 0 4px 12px rgba(37, 99, 235, 0.28);
    }

    .tab-badge {
        background: #f1f5f9;
        color: #475569;
        font-size: 11px;
        padding: 3px 8px;
        border-radius: 9999px;
        font-weight: 700;
    }

    .tab-btn.active .tab-badge {
        background: rgba(255, 255, 255, 0.25);
        color: #ffffff;
    }

    /* Cards */
    .card-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
        margin-bottom: 24px;
        overflow: hidden;
    }

    .card-panel-header {
        padding: 16px 22px;
        background: #f8fafc;
        border-bottom: 1px solid #e2e8f0;
        font-size: 15px;
        font-weight: 700;
        color: #1e293b;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-panel-body {
        padding: 22px;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 18px;
    }

    .form-label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-label .required {
        color: #ef4444;
        margin-left: 2px;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 9px 13px;
        font-size: 13px;
        color: #0f172a;
        background-color: #ffffff;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        transition: border-color 0.15s, box-shadow 0.15s;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        outline: 0;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control[readonly] {
        background-color: #f8fafc;
        color: #64748b;
        cursor: not-allowed;
    }

    .input-group {
        display: flex;
        align-items: stretch;
    }

    .input-group .form-control, .input-group .form-select {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group-btn {
        background-color: #f1f5f9;
        border: 1px solid #cbd5e1;
        border-left: none;
        padding: 0 14px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        cursor: pointer;
    }

    .row-grid-3 {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
        gap: 20px;
    }

    .row-grid-quick-add {
        display: grid;
        grid-template-columns: 3fr 1.5fr 1fr 1.5fr auto;
        gap: 12px;
        align-items: flex-end;
        background: #f8fafc;
        padding: 16px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
        margin-bottom: 20px;
    }

    @media (max-width: 992px) {
        .row-grid-quick-add {
            grid-template-columns: 1fr;
        }
    }

    /* Rekanan Badge */
    .rekanan-selected-badge {
        margin-top: 10px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 10px 14px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .rekanan-info {
        display: flex;
        align-items: center;
        gap: 10px;
        color: #1e40af;
    }

    .rekanan-details strong {
        display: block;
        font-size: 13px;
        color: #1e3a8a;
    }

    .rekanan-details span {
        font-size: 11px;
        color: #3b82f6;
    }

    /* Tables */
    .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
    }

    .data-table th {
        background-color: #f8fafc;
        padding: 12px 14px;
        font-weight: 700;
        color: #475569;
        border-bottom: 1px solid #e2e8f0;
        text-align: left;
        white-space: nowrap;
    }

    .data-table td {
        padding: 12px 14px;
        border-bottom: 1px solid #e2e8f0;
        vertical-align: middle;
        color: #1e293b;
    }

    .data-table tbody tr:hover {
        background-color: #f8fafc;
    }

    .badge-status {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 4px 10px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
    }

    .badge-status.success {
        background: #ecfdf5;
        color: #059669;
        border: 1px solid #a7f3d0;
    }

    .badge-status.info {
        background: #eff6ff;
        color: #2563eb;
        border: 1px solid #bfdbfe;
    }

    .badge-status.amber {
        background: #fffbeb;
        color: #d97706;
        border: 1px solid #fde68a;
    }

    /* Buttons */
    .btn-custom {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 18px;
        font-size: 13px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        border: 1px solid transparent;
        transition: all 0.15s ease;
        text-decoration: none;
    }

    .btn-primary-custom {
        background: #2563eb;
        color: #ffffff;
    }
    .btn-primary-custom:hover {
        background: #1d4ed8;
        color: #ffffff;
    }

    .btn-secondary-custom {
        background: #f1f5f9;
        color: #475569;
        border-color: #cbd5e1;
    }
    .btn-secondary-custom:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .btn-success-custom {
        background: #059669;
        color: #ffffff;
    }
    .btn-success-custom:hover {
        background: #047857;
        color: #ffffff;
    }

    .btn-danger-custom {
        background: #ef4444;
        color: #ffffff;
    }
    .btn-danger-custom:hover {
        background: #dc2626;
        color: #ffffff;
    }

    .btn-sm-action {
        width: 30px;
        height: 30px;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 13px;
        border: 1px solid #e2e8f0;
        background: #ffffff;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .btn-sm-action:hover {
        background: #f1f5f9;
        color: #0f172a;
    }

    .btn-sm-action.detail:hover {
        background: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }

    .btn-sm-action.print:hover {
        background: #f0fdf4;
        color: #16a34a;
        border-color: #bbf7d0;
    }

    .btn-sm-action.delete:hover {
        background: #fef2f2;
        color: #ef4444;
        border-color: #fecaca;
    }

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
        max-width: 820px;
        width: 100%;
        max-height: 90vh;
        overflow-y: auto;
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        animation: modalFadeIn 0.2s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-10px) scale(0.98); }
        to { opacity: 1; transform: translateY(0) scale(1); }
    }

    .modal-header-custom {
        padding: 18px 24px;
        border-bottom: 1px solid #e2e8f0;
        display: flex;
        align-items: center;
        justify-content: space-between;
        background: #f8fafc;
    }

    .modal-header-custom h3 {
        font-size: 17px;
        font-weight: 700;
        color: #0f172a;
    }

    .modal-body-custom {
        padding: 24px;
    }

    .modal-footer-custom {
        padding: 16px 24px;
        border-top: 1px solid #e2e8f0;
        display: flex;
        justify-content: flex-end;
        gap: 10px;
        background: #f8fafc;
    }
</style>
@endpush

@section('content')

<!-- Header & Navigasi Halaman -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-box-arrow-in-down"></i>
        </div>
        <div>
            <h1>Penerimaan Barang (Faktur Pembelian)</h1>
            <p>Pencatatan transaksi logistik masuk ke gudang menggunakan Oracle Sequences (<code>SEQ_GD_TERIMA_M</code> & <code>SEQ_GD_TERIMA_D</code>)</p>
        </div>
    </div>
    <div style="display: flex; align-items: center; gap: 10px; flex-wrap: wrap;">
        <div class="breadcrumb">
            <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Dashboard</a>
            <span>/</span>
            <span>Transaksi</span>
            <span>/</span>
            <span style="color: var(--text-main); font-weight: 600;">Faktur Pembelian</span>
        </div>
        <button type="button" class="btn btn-secondary" onclick="switchTab('list')">
            <i class="bi bi-list-ul"></i> Lihat Daftar Transaksi
        </button>
        <button type="button" class="btn btn-primary" onclick="switchTab('create')">
            <i class="bi bi-plus-circle-fill"></i> + Transaksi Masuk Baru
        </button>
    </div>
</div>

<!-- KPI Summary Cards -->
<div class="kpi-grid">
    <div class="kpi-card">
        <div class="kpi-icon blue">
            <i class="bi bi-receipt-cutoff"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($totalTransaksi) }}</h3>
            <p>Total Faktur Penerimaan</p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon emerald">
            <i class="bi bi-boxes"></i>
        </div>
        <div class="kpi-meta">
            <h3>{{ number_format($totalQtyBarang, 2, ',', '.') }}</h3>
            <p>Total Barang Diterima (Unit)</p>
        </div>
    </div>
    <div class="kpi-card">
        <div class="kpi-icon amber">
            <i class="bi bi-cash-stack"></i>
        </div>
        <div class="kpi-meta">
            <h3>Rp {{ number_format($totalNilaiFaktur, 0, ',', '.') }}</h3>
            <p>Akumulasi Nilai Transaksi</p>
        </div>
    </div>
</div>

<!-- Tab Navigation Switcher -->
<div class="nav-tabs-custom">
    <button type="button" class="tab-btn {{ $activeTab === 'list' ? 'active' : '' }}" id="tabBtnList" onclick="switchTab('list')">
        <i class="bi bi-table"></i>
        <span>Daftar Faktur Pembelian</span>
        <span class="tab-badge">{{ $totalTransaksi }}</span>
    </button>
    <button type="button" class="tab-btn {{ $activeTab === 'create' ? 'active' : '' }}" id="tabBtnCreate" onclick="switchTab('create')">
        <i class="bi bi-file-earmark-plus-fill"></i>
        <span>Formulir Penerimaan Barang Baru</span>
        <span class="tab-badge" style="background: #2563eb; color: #fff;">+ New</span>
    </button>
</div>

<!-- ========================================================
     TAB 1: DAFTAR TRANSAKSI PENERIMAAN PEMBELIAN
     ======================================================== -->
<div id="tabContentList" style="{{ $activeTab === 'list' ? 'display: block;' : 'display: none;' }}">
    
    <!-- Filter Panel -->
    <div class="card-panel">
        <div class="card-panel-header">
            <span><i class="bi bi-funnel-fill text-primary"></i> Filter & Pencarian Faktur</span>
            @if(request()->anyFilled(['q', 'id_rekanan', 'tgl_mulai', 'tgl_selesai']))
                <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn-custom btn-secondary-custom" style="padding: 4px 10px; font-size: 11px;">
                    <i class="bi bi-x-circle"></i> Reset Filter
                </a>
            @endif
        </div>
        <div class="card-panel-body" style="padding: 16px 20px;">
            <form method="GET" action="{{ route('transaksi.faktur-pembelian') }}">
                <input type="hidden" name="tab" value="list">
                <div class="row-grid-3" style="grid-template-columns: 2fr 1.5fr 2fr auto; align-items: flex-end;">
                    <div>
                        <label class="form-label">Kata Kunci (No. Transaksi / SJ / Keterangan)</label>
                        <div class="input-group">
                            <input type="text" name="q" class="form-control" placeholder="Cari nomor transaksi / SJ..." value="{{ request('q') }}">
                            <div class="input-group-btn"><i class="bi bi-search"></i></div>
                        </div>
                    </div>
                    <div>
                        <label class="form-label">Pemasok / Rekanan</label>
                        <select name="id_rekanan" class="form-select">
                            <option value="">Semua Pemasok</option>
                            @foreach($rekanans as $rek)
                                <option value="{{ $rek->id }}" {{ request('id_rekanan') == $rek->id ? 'selected' : '' }}>
                                    {{ $rek->nama_rekanan }} ({{ $rek->kode_rekanan }})
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="form-label">Rentang Tanggal Transaksi</label>
                        <div style="display: flex; gap: 8px;">
                            <input type="date" name="tgl_mulai" class="form-control" value="{{ request('tgl_mulai') }}" title="Mulai Tanggal">
                            <input type="date" name="tgl_selesai" class="form-control" value="{{ request('tgl_selesai') }}" title="Sampai Tanggal">
                        </div>
                    </div>
                    <div>
                        <button type="submit" class="btn-custom btn-primary-custom" style="height: 38px;">
                            <i class="bi bi-search"></i> Filter
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Data Table Card -->
    <div class="card-panel">
        <div class="card-panel-header">
            <span><i class="bi bi-database-fill-check text-primary"></i> Data Faktur Penerimaan (Oracle: <code>GD_TERIMA_BELI_M</code>)</span>
            <span style="font-size: 12px; color: #64748b; font-weight: 500;">Menampilkan {{ $transaksiList->firstItem() ?? 0 }} - {{ $transaksiList->lastItem() ?? 0 }} dari {{ $transaksiList->total() }} transaksi</span>
        </div>
        <div class="card-panel-body" style="padding: 0;">
            <div class="table-responsive">
                <table class="data-table">
                    <thead>
                        <tr>
                            <th style="width: 50px; text-align: center;">No</th>
                            <th style="width: 140px;">No. Transaksi</th>
                            <th style="width: 100px;">Tgl. Masuk</th>
                            <th style="width: 120px;">No. SJ</th>
                            <th>Pemasok / Rekanan</th>
                            <th style="text-align: center; width: 100px;">Jml Item</th>
                            <th style="text-align: right; width: 120px;">Total Qty</th>
                            <th style="text-align: right; width: 150px;">Total Nilai (Rp)</th>
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
                                <strong style="color: #2563eb; font-weight: 700;">{{ $trx->no_transaksi }}</strong>
                                <div style="font-size: 11px; color: #94a3b8;">ID: {{ $trx->id_transaksi }}</div>
                                @if($trx->po || $trx->no_po || $trx->id_po)
                                    <div style="margin-top: 4px;">
                                        <span class="badge-pill badge-blue" style="font-size: 10.5px; padding: 2px 8px;" title="Nomor Referensi Purchase Order">
                                            <i class="bi bi-file-earmark-text"></i> PO: {{ $trx->po?->no_transaksi ?? $trx->no_po ?? $trx->id_po }}
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td>
                                {{ $trx->tgl_transaksi ? \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d/m/Y') : '-' }}
                            </td>
                            <td>
                                <span style="font-family: monospace; background: #f1f5f9; padding: 2px 6px; border-radius: 4px;">
                                    {{ $trx->no_sj ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <strong>{{ $trx->rekanan ? $trx->rekanan->nama_rekanan : "Rekanan ID {$trx->id_rekanan}" }}</strong>
                                @if($trx->rekanan)
                                    <div style="font-size: 11px; color: #64748b;">{{ $trx->rekanan->kode_rekanan }}</div>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                <span class="badge-status info">
                                    <i class="bi bi-box-seam"></i> {{ $trx->details->count() }} item
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 600;">
                                {{ number_format($trx->total_kuantitas, 2, ',', '.') }}
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}
                            </td>
                            <td>
                                <div style="font-size: 12px; font-weight: 600;">{{ $trx->opr_insert ?? 'SYSTEM' }}</div>
                                <div style="font-size: 11px; color: #94a3b8;">
                                    {{ $trx->tgl_insert ? \Carbon\Carbon::parse($trx->tgl_insert)->format('d/m/y H:i') : '-' }}
                                </div>
                            </td>
                            <td style="text-align: center;">
                                <div style="display: inline-flex; gap: 6px;">
                                    <button type="button" class="btn-sm-action detail" title="Lihat Rincian Detail Barang" onclick="lihatDetailTransaksi({{ $trx->id_transaksi }})">
                                        <i class="bi bi-eye-fill"></i>
                                    </button>
                                    <a href="{{ route('transaksi.faktur-pembelian.cetak', $trx->id_transaksi) }}" target="_blank" class="btn-sm-action print" title="Cetak Bukti Penerimaan">
                                        <i class="bi bi-printer-fill"></i>
                                    </a>
                                    <button type="button" class="btn-sm-action delete" title="Batalkan Transaksi" onclick="hapusTransaksi({{ $trx->id_transaksi }}, '{{ $trx->no_transaksi }}')">
                                        <i class="bi bi-trash-fill"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="10" style="text-align: center; padding: 40px; color: #94a3b8;">
                                <i class="bi bi-inbox fs-1" style="display: block; margin-bottom: 8px;"></i>
                                <p style="font-weight: 600; font-size: 14px; color: #64748b;">Belum ada transaksi penerimaan pembelian yang tercatat.</p>
                                <button type="button" class="btn-custom btn-primary-custom" style="margin-top: 10px;" onclick="switchTab('create')">
                                    <i class="bi bi-plus-circle"></i> Buat Penerimaan Sekarang
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
                    Halaman {{ $transaksiList->currentPage() }} dari {{ $transaksiList->lastPage() }}
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
     TAB 2: FORMULIR PENERIMAAN BARANG BARU (INPUT FAKTUR)
     ======================================================== -->
<div id="tabContentCreate" style="{{ $activeTab === 'create' ? 'display: block;' : 'display: none;' }}">
    
    <form id="formFaktur" onsubmit="event.preventDefault(); simpanTransaksiKeOracle();">
        @csrf

        <!-- CARD 1: INFORMASI TRANSAKSI -->
        <div class="card-panel">
            <div class="card-panel-header">
                <span><i class="bi bi-file-earmark-text text-primary"></i> Informasi Header Transaksi (<code>GD_TERIMA_BELI_M</code>)</span>
                <span class="badge-status info">Sequence: SEQ_GD_TERIMA_M</span>
            </div>
            <div class="card-panel-body">
                <div class="row-grid-3">
                    
                    <!-- Kolom 1: No Transaksi & Tanggal -->
                    <div>
                        <div class="form-group">
                            <label class="form-label">No. Transaksi <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="noTransaksi" name="no_transaksi" value="{{ $noTransaksiPreview }}">
                                <button type="button" class="input-group-btn" title="Salin No. Transaksi" onclick="copyNoTransaksi()">
                                    <i class="bi bi-copy"></i>
                                </button>
                            </div>
                            <small style="font-size: 11px; color: #64748b;">Dihasilkan otomatis berdasarkan sequence counter Oracle.</small>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Tgl. Transaksi <span class="required">*</span></label>
                            <div class="input-group">
                                <input type="text" class="form-control" id="tglTransaksi" name="tgl_transaksi" value="{{ $tglTransaksi }}" required>
                                <div class="input-group-btn">
                                    <i class="bi bi-calendar3"></i>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Operator Insert</label>
                            <input type="text" class="form-control" value="{{ auth()->check() ? auth()->user()->name : 'SYSTEM' }}" readonly>
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Tgl. Insert</label>
                            <div class="input-group">
                                <input type="text" class="form-control" value="{{ $tglInsert }}" readonly>
                                <div class="input-group-btn">
                                    <i class="bi bi-clock-history"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Kolom 2: Purchase Order & Rekanan Terkunci -->
                    <div>
                        <div class="form-group">
                            <label class="form-label">Nomor Purchase Order (PO) <span class="required">*</span></label>
                            <select class="form-select" id="selectPO" name="id_po" onchange="muatDataPO(this.value)" required>
                                <option value="">-- Pilih Nomor Purchase Order (PO) --</option>
                                @foreach($poList as $po)
                                    <option value="{{ $po->id_transaksi }}" data-no="{{ $po->no_transaksi }}">
                                        {{ $po->no_transaksi }} - {{ $po->rekanan?->nama_rekanan ?? 'No Rekanan' }} ({{ $po->tgl_transaksi ? \Carbon\Carbon::parse($po->tgl_transaksi)->format('d/m/Y') : '-' }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group" style="margin-top: 6px;">
                                <input type="text" id="inputManualPO" class="form-control" placeholder="Atau ketik No. PO / ID PO..." style="font-size: 12px;">
                                <button type="button" class="btn btn-secondary" onclick="cariPoManual()" style="font-size: 12px; padding: 4px 12px;">
                                    <i class="bi bi-search"></i> Cari PO
                                </button>
                            </div>
                            <small style="font-size: 11px; color: #64748b;">Pilih PO untuk menarik data rekanan dan rincian barang otomatis dari database Oracle.</small>
                        </div>

                        <!-- Rekanan / Pemasok (Terkunci Otomatis dari PO) -->
                        <div class="form-group">
                            <label class="form-label">Pemasok / Vendor (Terkunci Otomatis dari PO)</label>
                            <input type="hidden" id="idRekanan" name="id_rekanan" value="">
                            <div class="rekanan-selected-badge" id="rekananBadge" style="display: flex;">
                                <div class="rekanan-info">
                                    <i class="bi bi-building-check fs-5 text-primary"></i>
                                    <div class="rekanan-details">
                                        <strong id="badgeNamaRekanan">Pilih Nomor PO terlebih dahulu</strong>
                                        <span id="badgeDetailRekanan">Data pemasok akan terisi otomatis setelah PO dipilih</span>
                                    </div>
                                </div>
                                <span class="badge-status success" id="badgePoLocked" style="display: none;">
                                    <i class="bi bi-lock-fill"></i> Terkunci PO
                                </span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">No. Surat Jalan (SJ)</label>
                            <input type="text" class="form-control" id="noSj" name="no_sj" placeholder="Misal: SJ-2026/X/001" value="-">
                        </div>

                        <div class="form-group" style="margin-bottom: 0;">
                            <label class="form-label">Tgl. Surat Jalan</label>
                            <input type="text" class="form-control" id="tglSj" name="tgl_sj" value="{{ $tglTransaksi }}">
                        </div>
                    </div>

                    <!-- Kolom 3: Keterangan Transaksi -->
                    <div>
                        <div class="form-group" style="height: 100%; display: flex; flex-direction: column;">
                            <label class="form-label">Keterangan / Catatan Transaksi</label>
                            <textarea class="form-control" id="keteranganTransaksi" name="keterangan" style="flex: 1; resize: vertical; min-height: 140px;" placeholder="Tuliskan catatan faktur pembelian barang...">Penerimaan barang pembelian operasional gudang</textarea>
                        </div>
                    </div>

                </div>
            </div>
        </div>

        <!-- CARD 2: DETAIL BARANG (TERIKAT KE PO) -->
        <div class="card-panel">
            <div class="card-panel-header">
                <span><i class="bi bi-boxes text-primary"></i> Detail Barang yang Diterima (<code>GD_TERIMA_BELI_D</code>)</span>
                <span class="badge-status info">Sequence: SEQ_GD_TERIMA_D</span>
            </div>
            <div class="card-panel-body">
                
                <!-- Notice Aturan Bisnis PO (Tombol Tambah Barang Manual Ditiadakan) -->
                <div class="alert-info-po" id="poAlertInfo" style="background: #eff6ff; border: 1px solid #bfdbfe; border-radius: 12px; padding: 16px 20px; margin-bottom: 20px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap;">
                    <div style="display: flex; align-items: center; gap: 14px;">
                        <div style="width: 42px; height: 42px; border-radius: 10px; background: #dbeafe; display: flex; align-items: center; justify-content: center; color: #1d4ed8; font-size: 20px; flex-shrink: 0;">
                            <i class="bi bi-shield-lock-fill"></i>
                        </div>
                        <div>
                            <div style="font-weight: 700; color: #1e3a8a; font-size: 13.5px;" id="poStatusTitle">
                                Aturan Bisnis Penerimaan PO Aktif
                            </div>
                            <div style="font-size: 12px; color: #475569; margin-top: 2px;" id="poStatusDesc">
                                Seluruh barang ditarik otomatis dari Purchase Order. <strong>User TIDAK BOLEH menambah item barang baru</strong> di luar PO. Anda hanya diizinkan untuk merevisi jumlah kuantitas (Qty) barang yang diterima.
                            </div>
                        </div>
                    </div>
                    <div id="poInfoBadgeWrap" style="display: none;">
                        <span class="badge-pill badge-blue" id="poBadgeSummary" style="font-size: 12px; padding: 6px 12px;">
                            0 Item Terdaftar di PO
                        </span>
                    </div>
                </div>

                <!-- Table Daftar Detail Barang dari PO -->
                <div class="table-responsive">
                    <table class="data-table" id="tableBarang">
                        <thead>
                            <tr>
                                <th style="width: 50px; text-align: center;">No</th>
                                <th style="width: 130px;">Kode Barang</th>
                                <th>Nama Barang</th>
                                <th style="width: 120px; text-align: center;">Satuan</th>
                                <th style="width: 120px; text-align: right;">Qty PO</th>
                                <th style="width: 140px; text-align: right;">Qty Diterima <span class="required">*</span></th>
                                <th style="width: 140px; text-align: right;">Harga Satuan</th>
                                <th style="width: 160px; text-align: right;">Subtotal (Rp)</th>
                                <th style="width: 130px; text-align: center;">Status Verifikasi</th>
                            </tr>
                        </thead>
                        <tbody id="tbodyBarang">
                            <tr>
                                <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                                    <i class="bi bi-receipt" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                                    <strong style="color: #64748b;">Belum ada Purchase Order (PO) yang dipilih.</strong>
                                    <div style="font-size: 12px; margin-top: 4px;">Silakan pilih atau cari Nomor PO pada formulir di atas untuk memuat daftar barang secara otomatis.</div>
                                </td>
                            </tr>
                        </tbody>
                        <tfoot>
                            <tr style="background: #f8fafc; font-weight: 800; font-size: 14px; border-top: 2px solid #cbd5e1;">
                                <td colspan="5" style="text-align: right; color: #475569;">TOTAL KUANTITAS & NILAI DITERIMA:</td>
                                <td style="text-align: right; color: #2563eb;" id="grandTotalQty">0.00</td>
                                <td></td>
                                <td style="text-align: right; color: #0f172a;" id="grandTotalText">Rp 0</td>
                                <td></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>

        <!-- FORM ACTION BUTTONS -->
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-bottom: 40px;">
            <button type="button" class="btn-custom btn-secondary-custom" onclick="switchTab('list')">
                <i class="bi bi-x-circle"></i> Batal
            </button>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="resetFormFaktur()">
                <i class="bi bi-arrow-counterclockwise"></i> Reset Isian
            </button>
            <button type="submit" id="btnSubmitFaktur" class="btn-custom btn-success-custom" style="padding: 10px 24px; font-size: 14px;">
                <i class="bi bi-save2-fill"></i> Simpan ke Oracle Database
            </button>
        </div>

    </form>

</div>

<!-- ========================================================
     MODAL DETAIL TRANSAKSI (POPUP)
     ======================================================== -->
<div class="modal-backdrop-custom" id="modalDetail">
    <div class="modal-dialog-custom">
        <div class="modal-header-custom">
            <div>
                <h3 id="modalDetailTitle">Rincian Faktur Pembelian</h3>
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
                    <div style="font-size: 11px; color: #64748b; font-weight: 600;">PEMASOK / VENDOR:</div>
                    <strong style="font-size: 14px; color: #1e3a8a;" id="modalRekananNama">-</strong>
                    <div style="font-size: 12px; color: #475569;" id="modalRekananAlamat">-</div>
                </div>
                <div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748b; font-size: 12px;">Referensi PO:</span>
                        <strong id="modalNoPo" style="color: #2563eb;">-</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748b; font-size: 12px;">Tanggal Masuk:</span>
                        <strong id="modalTglMasuk">-</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between; margin-bottom: 4px;">
                        <span style="color: #64748b; font-size: 12px;">No. Surat Jalan:</span>
                        <strong id="modalNoSj">-</strong>
                    </div>
                    <div style="display: flex; justify-content: space-between;">
                        <span style="color: #64748b; font-size: 12px;">Petugas Input:</span>
                        <span id="modalOperator">-</span>
                    </div>
                </div>
            </div>

            <!-- Detail Barang Table -->
            <div class="table-responsive">
                <table class="data-table" id="modalTableBarang">
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">No</th>
                            <th style="width: 120px;">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style="width: 100px; text-align: center;">Satuan</th>
                            <th style="width: 90px; text-align: right;">Jumlah</th>
                            <th style="width: 120px; text-align: right;">Harga Satuan</th>
                            <th style="width: 140px; text-align: right;">Subtotal</th>
                        </tr>
                    </thead>
                    <tbody id="modalTbodyBarang">
                        <!-- Loaded dynamically -->
                    </tbody>
                    <tfoot>
                        <tr style="background: #f8fafc; font-weight: 800; border-top: 2px solid #cbd5e1;">
                            <td colspan="4" style="text-align: right;">GRAND TOTAL:</td>
                            <td style="text-align: right; color: #2563eb;" id="modalTotalQty">0.00</td>
                            <td></td>
                            <td style="text-align: right; color: #0f172a;" id="modalTotalNilai">Rp 0</td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="modal-footer-custom">
            <a href="#" id="modalBtnCetak" target="_blank" class="btn-custom btn-primary-custom">
                <i class="bi bi-printer"></i> Cetak Bukti Penerimaan
            </a>
            <button type="button" class="btn-custom btn-secondary-custom" onclick="tutupModalDetail()">
                Tutup
            </button>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
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
        } else {
            tabList.style.display = 'block';
            tabCreate.style.display = 'none';
            btnList.classList.add('active');
            btnCreate.classList.remove('active');
        }
    }

    // Salin Nomor Transaksi
    function copyNoTransaksi() {
        const input = document.getElementById('noTransaksi');
        navigator.clipboard.writeText(input.value);
        alert('Nomor transaksi disalin: ' + input.value);
    }

    // Formatting Rupiah
    function formatRupiah(amount) {
        return new Intl.NumberFormat('id-ID').format(amount);
    }

    // Pencarian Manual Nomor PO
    function cariPoManual() {
        const val = document.getElementById('inputManualPO').value.trim();
        if (!val) {
            alert('Masukkan Nomor PO atau ID PO yang ingin dicari.');
            return;
        }
        muatDataPO(val);
    }

    // Muat Data Purchase Order via AJAX dari Oracle
    function muatDataPO(poId) {
        if (!poId) {
            resetFormPO();
            return;
        }

        const tbody = document.getElementById('tbodyBarang');
        tbody.innerHTML = `
            <tr>
                <td colspan="9" style="text-align: center; padding: 36px 20px; color: #2563eb;">
                    <div style="font-size: 18px; margin-bottom: 8px;"><i class="bi bi-arrow-repeat spin"></i></div>
                    <strong>Menghubungkan ke Oracle DB & Menarik Data Purchase Order...</strong>
                </td>
            </tr>
        `;

        fetch(`{{ url('transaksi/faktur-pembelian/po') }}/${encodeURIComponent(poId)}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (!res.success) {
                alert('❌ ' + (res.message || 'Gagal memuat data Purchase Order.'));
                resetFormPO();
                return;
            }

            const data = res.data;

            // 1. Sinkronisasi Data Rekanan / Vendor (Otomatis & Terkunci dari PO)
            document.getElementById('idRekanan').value = data.id_rekanan;
            document.getElementById('badgeNamaRekanan').innerText = data.rekanan.nama;
            document.getElementById('badgeDetailRekanan').innerText = `${data.rekanan.kode} • ${data.rekanan.alamat} (${data.rekanan.no_telp})`;
            document.getElementById('badgePoLocked').style.display = 'inline-flex';

            // Sinkronisasi opsi select jika pencarian via teks manual
            const selectPO = document.getElementById('selectPO');
            if (selectPO.value != data.id_transaksi) {
                let foundOption = false;
                for (let i = 0; i < selectPO.options.length; i++) {
                    if (selectPO.options[i].value == data.id_transaksi) {
                        selectPO.selectedIndex = i;
                        foundOption = true;
                        break;
                    }
                }
                if (!foundOption) {
                    const newOpt = new Option(`${data.no_transaksi} - ${data.rekanan.nama} (${data.tgl_transaksi})`, data.id_transaksi, true, true);
                    selectPO.add(newOpt);
                }
            }

            // 2. Info Status Banner PO
            document.getElementById('poStatusTitle').innerHTML = `PO Terpilih: <strong style="color: #2563eb;">${data.no_transaksi}</strong> (ID: ${data.id_transaksi})`;
            document.getElementById('poStatusDesc').innerHTML = `Tgl PO: <strong>${data.tgl_transaksi}</strong> • Vendor: <strong>${data.rekanan.nama}</strong>. Kuantitas pesanan terkunci dari PO. Anda dapat merevisi kuantitas aktual yang diterima.`;
            document.getElementById('poInfoBadgeWrap').style.display = 'block';
            document.getElementById('poBadgeSummary').innerText = `${data.total_items} Item Terdaftar di PO`;

            // 3. Render Detail Barang Persis dari PO
            tbody.innerHTML = '';
            data.items.forEach((item, idx) => {
                const tr = document.createElement('tr');
                tr.className = 'item-row';
                const defaultQty = item.sisa_qty > 0 ? item.sisa_qty : item.qty_po;
                const subtotal = defaultQty * item.harga;

                tr.innerHTML = `
                    <td style="text-align: center; color: #64748b; font-weight: 600;">${idx + 1}</td>
                    <td>
                        <span class="badge-code">${item.kode_barang}</span>
                        <input type="hidden" class="item-id-po-detail" value="${item.id_detail}">
                        <input type="hidden" class="item-id-barang" value="${item.id_barang}">
                        <input type="hidden" class="item-id-satuan" value="${item.id_satuan}">
                        <input type="hidden" class="item-harga" value="${item.harga}">
                    </td>
                    <td>
                        <strong style="color: #0f172a; font-size: 13.5px;">${item.nama_barang}</strong>
                        ${item.sudah_diterima > 0 ? `<div style="font-size: 11px; color: #d97706; margin-top: 2px;"><i class="bi bi-clock-history"></i> Sudah diterima sebelumnya: ${item.sudah_diterima}</div>` : ''}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge-pill badge-blue">${item.nama_satuan}</span>
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #475569;">
                        ${item.qty_po.toFixed(2)}
                    </td>
                    <td style="text-align: right;">
                        <input type="number" 
                               step="0.01" 
                               min="0.01" 
                               max="${item.qty_po}" 
                               class="form-control item-qty" 
                               style="padding: 6px 10px; text-align: right; font-weight: 700; color: #1e40af; border-color: #93c5fd; background: #f0fdf4;" 
                               value="${defaultQty}" 
                               title="Kuantitas yang diterima di gudang (Maks: ${item.qty_po})"
                               oninput="hitungSubtotalBaris(this)">
                        <small style="font-size: 10.5px; color: #64748b; display: block; margin-top: 2px;">Maks PO: ${item.qty_po}</small>
                    </td>
                    <td style="text-align: right; color: #475569; font-weight: 600;">
                        Rp ${formatRupiah(item.harga)}
                    </td>
                    <td style="text-align: right; font-weight: 700; color: #0f172a;" class="item-subtotal-text">
                        Rp ${formatRupiah(subtotal)}
                    </td>
                    <td style="text-align: center;">
                        <span class="badge-status success" title="Item resmi terverifikasi dari PO">
                            <i class="bi bi-check-circle-fill"></i> Terverifikasi PO
                        </span>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            hitungGrandTotal();
        })
        .catch(err => {
            tbody.innerHTML = `
                <tr>
                    <td colspan="9" style="text-align: center; padding: 24px; color: #ef4444;">
                        <i class="bi bi-exclamation-triangle-fill"></i> Gagal terhubung ke server atau database Oracle: ${err.message}
                    </td>
                </tr>
            `;
        });
    }

    // Hitung Subtotal per baris
    function hitungSubtotalBaris(inputElem) {
        const row = inputElem.closest('tr');
        const qty = parseFloat(inputElem.value) || 0;
        const maxQty = parseFloat(inputElem.getAttribute('max')) || 0;
        const harga = parseFloat(row.querySelector('.item-harga').value) || 0;

        if (maxQty > 0 && qty > maxQty) {
            inputElem.style.borderColor = '#ef4444';
            inputElem.style.background = '#fef2f2';
            inputElem.style.color = '#b91c1c';
            alert(`⚠️ Peringatan: Kuantitas diterima (${qty}) melebihi kuantitas pesanan PO (${maxQty}). Kuantitas telah dikembalikan ke batas maksimum PO.`);
            inputElem.value = maxQty;
            inputElem.style.borderColor = '#93c5fd';
            inputElem.style.background = '#f0fdf4';
            inputElem.style.color = '#1e40af';
        } else {
            inputElem.style.borderColor = '#93c5fd';
            inputElem.style.background = '#f0fdf4';
            inputElem.style.color = '#1e40af';
        }

        const validQty = parseFloat(inputElem.value) || 0;
        const subtotal = validQty * harga;

        row.querySelector('.item-subtotal-text').innerText = 'Rp ' + formatRupiah(subtotal);
        hitungGrandTotal();
    }

    // Hitung Grand Total
    function hitungGrandTotal() {
        let totalQty = 0;
        let totalNilai = 0;
        const rows = document.querySelectorAll('#tbodyBarang tr.item-row');

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
            const harga = parseFloat(row.querySelector('.item-harga')?.value) || 0;
            totalQty += qty;
            totalNilai += (qty * harga);
        });

        document.getElementById('grandTotalQty').innerText = totalQty.toFixed(2);
        document.getElementById('grandTotalText').innerText = 'Rp ' + formatRupiah(totalNilai);
    }

    // Reset Form & Kembalikan ke State Awal
    function resetFormFaktur() {
        if (confirm('Bersihkan isian formulir penerimaan?')) {
            document.getElementById('selectPO').value = '';
            document.getElementById('inputManualPO').value = '';
            document.getElementById('keteranganTransaksi').value = '';
            resetFormPO();
        }
    }

    function resetFormPO() {
        document.getElementById('idRekanan').value = '';
        document.getElementById('badgeNamaRekanan').innerText = 'Pilih Nomor PO terlebih dahulu';
        document.getElementById('badgeDetailRekanan').innerText = 'Data rekanan akan terisi otomatis setelah PO dipilih';
        document.getElementById('badgePoLocked').style.display = 'none';

        document.getElementById('poStatusTitle').innerText = 'Aturan Bisnis Penerimaan PO Aktif';
        document.getElementById('poStatusDesc').innerHTML = 'Seluruh barang ditarik otomatis dari Purchase Order. <strong>User TIDAK BOLEH menambah item barang baru</strong> di luar PO. Anda hanya diizinkan untuk merevisi jumlah kuantitas (Qty) barang yang diterima.';
        document.getElementById('poInfoBadgeWrap').style.display = 'none';

        const tbody = document.getElementById('tbodyBarang');
        tbody.innerHTML = `
            <tr>
                <td colspan="9" style="text-align: center; padding: 40px 20px; color: #94a3b8;">
                    <i class="bi bi-receipt" style="font-size: 32px; display: block; margin-bottom: 8px; color: #cbd5e1;"></i>
                    <strong style="color: #64748b;">Belum ada Purchase Order (PO) yang dipilih.</strong>
                    <div style="font-size: 12px; margin-top: 4px;">Silakan pilih atau cari Nomor PO pada formulir di atas untuk memuat daftar barang secara otomatis.</div>
                </td>
            </tr>
        `;

        document.getElementById('grandTotalQty').innerText = '0.00';
        document.getElementById('grandTotalText').innerText = 'Rp 0';
    }

    // Simpan Transaksi ke Database Oracle
    function simpanTransaksiKeOracle() {
        const idPo = document.getElementById('selectPO').value;
        if (!idPo) {
            alert('⚠️ Nomor Purchase Order (PO) wajib dipilih terlebih dahulu.');
            document.getElementById('selectPO').focus();
            return;
        }

        const rows = document.querySelectorAll('#tbodyBarang tr.item-row');
        if (rows.length === 0) {
            alert('⚠️ Purchase Order tidak memiliki item barang yang dapat diproses.');
            return;
        }

        const items = [];
        let valid = true;

        rows.forEach((row, idx) => {
            const idPoDetail = row.querySelector('.item-id-po-detail').value;
            const idBarang = row.querySelector('.item-id-barang').value;
            const idSatuan = row.querySelector('.item-id-satuan').value;
            const jumlah = parseFloat(row.querySelector('.item-qty').value) || 0;
            const maxQty = parseFloat(row.querySelector('.item-qty').getAttribute('max')) || 0;

            if (jumlah <= 0) {
                alert(`Baris ke-${idx + 1}: Kuantitas barang yang diterima harus lebih besar dari 0.`);
                valid = false;
                return;
            }

            if (maxQty > 0 && jumlah > maxQty) {
                alert(`Baris ke-${idx + 1}: Kuantitas diterima (${jumlah}) melebihi pesanan PO (${maxQty}). Kuantitas tidak boleh melebihi pesanan PO!`);
                valid = false;
                return;
            }

            items.push({
                id_po_detail: idPoDetail,
                id_barang: idBarang,
                id_satuan: idSatuan,
                jumlah: jumlah,
            });
        });

        if (!valid) return;

        const payload = {
            _token: '{{ csrf_token() }}',
            id_po: idPo,
            no_transaksi: document.getElementById('noTransaksi').value,
            tgl_transaksi: document.getElementById('tglTransaksi').value,
            no_sj: document.getElementById('noSj').value,
            tgl_sj: document.getElementById('tglSj').value,
            keterangan: document.getElementById('keteranganTransaksi').value,
            items: items,
        };

        const submitBtn = document.getElementById('btnSubmitFaktur');
        submitBtn.disabled = true;
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split"></i> Menyimpan ke Oracle...';

        fetch("{{ route('transaksi.faktur-pembelian.store') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        })
        .then(response => response.json().then(data => ({ status: response.status, body: data })))
        .then(({ status, body }) => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan ke Oracle Database';

            if (body.success) {
                alert('✅ ' + body.message);
                window.location.href = "{{ route('transaksi.faktur-pembelian') }}?tab=list";
            } else {
                alert('❌ Gagal: ' + (body.message || 'Terjadi kesalahan pada database Oracle.'));
            }
        })
        .catch(err => {
            submitBtn.disabled = false;
            submitBtn.innerHTML = '<i class="bi bi-save2-fill"></i> Simpan ke Oracle Database';
            alert('❌ Terjadi kesalahan jaringan atau server: ' + err.message);
        });
    }

    // Lihat Rincian Detail Transaksi (Modal)
    function lihatDetailTransaksi(idTransaksi) {
        fetch(`{{ url('transaksi/faktur-pembelian') }}/${idTransaksi}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(res => res.json())
        .then(res => {
            if (res.success) {
                const data = res.data;
                document.getElementById('modalDetailTitle').innerText = `Rincian Faktur: ${data.no_transaksi}`;
                document.getElementById('modalDetailSubtitle').innerText = `ID Transaksi Oracle: ${data.id_transaksi} • Tgl Input: ${data.tgl_insert}`;
                
                document.getElementById('modalNoPo').innerText = data.no_po || '-';
                document.getElementById('modalRekananNama').innerText = data.rekanan.nama;
                document.getElementById('modalRekananAlamat').innerText = `${data.rekanan.kode} • ${data.rekanan.alamat} (${data.rekanan.no_telp})`;

                document.getElementById('modalTglMasuk').innerText = data.tgl_transaksi;
                document.getElementById('modalNoSj').innerText = data.no_sj;
                document.getElementById('modalOperator').innerText = data.opr_insert;

                const tbody = document.getElementById('modalTbodyBarang');
                tbody.innerHTML = '';

                data.items.forEach(item => {
                    const tr = document.createElement('tr');
                    tr.innerHTML = `
                        <td style="text-align: center; color: #64748b;">${item.no_urut}</td>
                        <td><strong style="color: #2563eb;">${item.kode_barang}</strong></td>
                        <td>${item.nama_barang}</td>
                        <td style="text-align: center;">${item.satuan}</td>
                        <td style="text-align: right; font-weight: 600;">${item.jumlah.toFixed(2)}</td>
                        <td style="text-align: right;">${formatRupiah(item.harga_satuan)}</td>
                        <td style="text-align: right; font-weight: 700;">${formatRupiah(item.total)}</td>
                    `;
                    tbody.appendChild(tr);
                });

                document.getElementById('modalTotalQty').innerText = data.total_kuantitas.toFixed(2);
                document.getElementById('modalTotalNilai').innerText = 'Rp ' + formatRupiah(data.total_nilai);

                // Set cetak URL
                document.getElementById('modalBtnCetak').href = `{{ url('transaksi/faktur-pembelian') }}/${data.id_transaksi}/cetak`;

                // Show modal
                document.getElementById('modalDetail').classList.add('show');
            } else {
                alert('Gagal mengambil detail transaksi.');
            }
        })
        .catch(err => {
            alert('Kesalahan saat memuat data: ' + err.message);
        });
    }

    function tutupModalDetail() {
        document.getElementById('modalDetail').classList.remove('show');
    }

    // Hapus / Batalkan Transaksi
    function hapusTransaksi(idTransaksi, noTransaksi) {
        if (!confirm(`Apakah Anda yakin ingin membatalkan & menghapus transaksi penerimaan [${noTransaksi}] dari Database Oracle?`)) {
            return;
        }

        fetch(`{{ url('transaksi/faktur-pembelian') }}/${idTransaksi}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
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
</script>
@endpush

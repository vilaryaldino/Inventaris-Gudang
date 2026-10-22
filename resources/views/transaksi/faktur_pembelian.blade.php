@extends('layouts.app')

@section('title', 'Faktur Pembelian')

@push('styles')
<style>
    /* Page Header */
    .page-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 24px;
    }

    .page-title-box {
        display: flex;
        align-items: center;
        gap: 14px;
    }

    .page-icon {
        width: 44px;
        height: 44px;
        background: #2563eb;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #ffffff;
        font-size: 22px;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.25);
    }

    .page-title-box h1 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        line-height: 1.2;
    }

    .page-title-box p {
        font-size: 13px;
        color: #64748b;
        margin-top: 2px;
    }

    .breadcrumb {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        color: #64748b;
    }

    .breadcrumb a {
        color: #2563eb;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }

    .breadcrumb a:hover {
        text-decoration: underline;
    }

    /* Cards */
    .card-panel {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        box-shadow: 0 1px 3px 0 rgba(0, 0, 0, 0.05);
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
        gap: 8px;
    }

    .card-panel-body {
        padding: 22px;
    }

    /* Form Controls */
    .form-group {
        margin-bottom: 16px;
    }

    .form-label {
        display: block;
        font-size: 12.5px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-label .required {
        color: #ef4444;
    }

    .input-group {
        display: flex;
        position: relative;
    }

    .form-control, .form-select {
        width: 100%;
        padding: 8px 12px;
        font-size: 13px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        background-color: #ffffff;
        color: #0f172a;
        transition: all 0.2s ease;
        outline: none;
        font-family: inherit;
    }

    .form-control:focus, .form-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.15);
    }

    .form-control:disabled, .form-control[readonly] {
        background-color: #f1f5f9;
        color: #475569;
        cursor: not-allowed;
    }

    .input-group .form-control {
        border-top-right-radius: 0;
        border-bottom-right-radius: 0;
    }

    .input-group-btn {
        background-color: #f8fafc;
        border: 1px solid #cbd5e1;
        border-left: none;
        padding: 0 12px;
        border-top-right-radius: 8px;
        border-bottom-right-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #64748b;
        cursor: pointer;
        transition: all 0.2s;
    }

    .input-group-btn:hover {
        background-color: #e2e8f0;
        color: #0f172a;
    }

    /* Selected Rekanan Alert / Pill */
    .rekanan-selected-badge {
        background-color: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 8px;
        padding: 10px 14px;
        margin-top: 10px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        color: #1e40af;
    }

    .rekanan-info {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .rekanan-info i {
        font-size: 18px;
        color: #2563eb;
    }

    .rekanan-details strong {
        font-size: 13px;
        font-weight: 700;
        display: block;
    }

    .rekanan-details span {
        font-size: 11.5px;
        color: #3b82f6;
    }

    .btn-close-rekanan {
        background: none;
        border: none;
        color: #3b82f6;
        cursor: pointer;
        font-size: 16px;
        padding: 2px;
    }

    .btn-close-rekanan:hover {
        color: #1e3a8a;
    }

    /* Grid Layouts */
    .row-grid-3 {
        display: grid;
        grid-template-columns: 1fr 1fr 1.2fr;
        gap: 20px;
    }

    .row-grid-quick-add {
        display: grid;
        grid-template-columns: 2fr 1fr 1.2fr 1.2fr auto;
        gap: 12px;
        align-items: flex-end;
        margin-bottom: 20px;
        background: #f8fafc;
        padding: 14px 18px;
        border-radius: 10px;
        border: 1px solid #e2e8f0;
    }

    /* Table Styles */
    .table-container {
        overflow-x: auto;
        border: 1px solid #e2e8f0;
        border-radius: 8px;
        margin-bottom: 16px;
    }

    .custom-table {
        width: 100%;
        border-collapse: collapse;
        font-size: 13px;
        text-align: left;
    }

    .custom-table th {
        background-color: #f8fafc;
        padding: 11px 14px;
        font-weight: 700;
        color: #334155;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .custom-table td {
        padding: 8px 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .custom-table tr:hover {
        background-color: #fbfcfe;
    }

    .custom-table .table-input {
        width: 100%;
        padding: 6px 10px;
        font-size: 12.5px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        text-align: right;
        outline: none;
    }

    .custom-table .table-input:focus {
        border-color: #2563eb;
    }

    .custom-table .table-select {
        width: 100%;
        padding: 6px 8px;
        font-size: 12px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        background-color: #ffffff;
    }

    .action-btn-group {
        display: flex;
        gap: 6px;
        justify-content: center;
    }

    .btn-action-edit {
        width: 30px;
        height: 30px;
        background-color: #2563eb;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .btn-action-edit:hover {
        background-color: #1d4ed8;
    }

    .btn-action-delete {
        width: 30px;
        height: 30px;
        background-color: #ef4444;
        color: white;
        border: none;
        border-radius: 6px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background-color 0.2s;
    }

    .btn-action-delete:hover {
        background-color: #dc2626;
    }

    /* Buttons */
    .btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 9px 18px;
        font-size: 13.5px;
        font-weight: 600;
        border-radius: 8px;
        border: 1px solid transparent;
        cursor: pointer;
        transition: all 0.2s ease;
        text-decoration: none;
    }

    .btn-primary {
        background-color: #2563eb;
        color: #ffffff;
    }
    .btn-primary:hover {
        background-color: #1d4ed8;
        box-shadow: 0 4px 10px rgba(37, 99, 235, 0.3);
    }

    .btn-success {
        background-color: #10b981;
        color: #ffffff;
    }
    .btn-success:hover {
        background-color: #059669;
        box-shadow: 0 4px 10px rgba(16, 185, 129, 0.3);
    }

    .btn-secondary {
        background-color: #eff6ff;
        color: #2563eb;
        border-color: #bfdbfe;
    }
    .btn-secondary:hover {
        background-color: #dbeafe;
    }

    .btn-light {
        background-color: #ffffff;
        color: #334155;
        border-color: #cbd5e1;
    }
    .btn-light:hover {
        background-color: #f1f5f9;
        border-color: #94a3b8;
    }

    /* Bottom Action Bar */
    .action-bar-footer {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 10px;
        padding-top: 10px;
    }

    .action-bar-left {
        display: flex;
        gap: 10px;
    }

    .total-box {
        background-color: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 10px;
        padding: 10px 24px;
        text-align: right;
    }

    .total-box-label {
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        color: #047857;
        letter-spacing: 0.05em;
    }

    .total-box-amount {
        font-size: 22px;
        font-weight: 800;
        color: #065f46;
        letter-spacing: -0.02em;
    }

    @media (max-width: 900px) {
        .row-grid-3, .row-grid-quick-add {
            grid-template-columns: 1fr;
        }
        .action-bar-footer {
            flex-direction: column-reverse;
            gap: 16px;
            align-items: stretch;
        }
        .total-box {
            text-align: center;
        }
    }
</style>
@endpush

@section('content')

<!-- ====================================================
     PAGE TITLE & BREADCRUMB
     ==================================================== -->
<div class="page-header">
    <div class="page-title-box">
        <div class="page-icon">
            <i class="bi bi-file-earmark-text-fill"></i>
        </div>
        <div>
            <h1>Faktur Pembelian</h1>
            <p>Input dan kelola data faktur pembelian barang masuk ke gudang</p>
        </div>
    </div>
    <div class="breadcrumb">
        <a href="{{ route('dashboard') }}"><i class="bi bi-house-door-fill"></i> Home</a>
        <span>/</span>
        <span>Faktur Pembelian</span>
    </div>
</div>

<form id="formFaktur" onsubmit="event.preventDefault(); simpanTransaksi();">
    <!-- ====================================================
         CARD 1: INFORMASI TRANSAKSI
         ==================================================== -->
    <div class="card-panel">
        <div class="card-panel-header">
            <i class="bi bi-info-circle-fill text-primary"></i>
            <span>Informasi Transaksi</span>
        </div>
        <div class="card-panel-body">
            <div class="row-grid-3">
                
                <!-- Kolom 1: No Transaksi & Tanggal -->
                <div>
                    <div class="form-group">
                        <label class="form-label">No. Transaksi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="noTransaksi" value="{{ $noTransaksi }}" readonly>
                            <button type="button" class="input-group-btn" title="Salin No. Transaksi" onclick="copyNoTransaksi()">
                                <i class="bi bi-copy"></i>
                            </button>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Tgl. Transaksi</label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="tglTransaksi" value="{{ $tglTransaksi }}">
                            <div class="input-group-btn">
                                <i class="bi bi-calendar3"></i>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Opr. Insert</label>
                        <input type="text" class="form-control" value="admin" readonly>
                    </div>

                    <div class="form-group" style="margin-bottom: 0;">
                        <label class="form-label">Tgl. Insert</label>
                        <div class="input-group">
                            <input type="text" class="form-control" value="{{ $tglInsert }}" readonly>
                            <div class="input-group-btn">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kolom 2: Kode Transaksi & Rekanan -->
                <div>
                    <div class="form-group">
                        <label class="form-label">Kode Transaksi</label>
                        <select class="form-select" id="kodeTransaksi">
                            <option value="FAKTUR" selected>FAKTUR</option>
                            <option value="NOTA">NOTA PEMBELIAN</option>
                            <option value="SURAT_JALAN">SURAT JALAN / DELIVERY</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Pilih Rekanan <span class="required">*</span></label>
                        <div class="input-group">
                            <select class="form-select" id="selectRekanan" onchange="updateRekananBadge()">
                                <option value="">-- Cari atau pilih rekanan/supplier --</option>
                                @foreach($rekanans as $rek)
                                    <option value="{{ $rek->id }}" 
                                            data-kode="{{ $rek->kode_rekanan }}" 
                                            data-nama="{{ $rek->nama_rekanan }}" 
                                            data-alamat="{{ $rek->alamat }}"
                                            {{ $rek->kode_rekanan == 'R12345' ? 'selected' : '' }}>
                                        {{ $rek->nama_rekanan }} ({{ $rek->kode_rekanan }})
                                    </option>
                                @endforeach
                            </select>
                            <div class="input-group-btn">
                                <i class="bi bi-search"></i>
                            </div>
                        </div>

                        <!-- Rekanan Badge Preview (Matches Screenshot) -->
                        <div class="rekanan-selected-badge" id="rekananBadge">
                            <div class="rekanan-info">
                                <i class="bi bi-info-circle-fill"></i>
                                <div class="rekanan-details">
                                    <strong id="badgeNamaRekanan">CV. Sumber Rejeki</strong>
                                    <span id="badgeDetailRekanan">R12345 - Jakarta</span>
                                </div>
                            </div>
                            <button type="button" class="btn-close-rekanan" onclick="clearRekanan()" title="Hapus Pilihan">
                                <i class="bi bi-x-lg"></i>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Kolom 3: Keterangan -->
                <div>
                    <div class="form-group" style="height: 100%;">
                        <label class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keteranganTransaksi" rows="8" style="resize: vertical;" placeholder="Tuliskan keterangan faktur pembelian...">Pembelian bahan baku bulan Oktober 2026</textarea>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- ====================================================
         CARD 2: DETAIL BARANG
         ==================================================== -->
    <div class="card-panel">
        <div class="card-panel-header">
            <i class="bi bi-boxes text-primary"></i>
            <span>Detail Barang</span>
        </div>
        <div class="card-panel-body">
            
            <!-- Quick Add Bar -->
            <div class="row-grid-quick-add">
                <div>
                    <label class="form-label">Cari Barang</label>
                    <select class="form-select" id="quickBarang" onchange="autoFillBarang()">
                        <option value="">-- Pilih Barang dari Master --</option>
                        @foreach($items as $it)
                            <option value="{{ $it->kode_barang }}" 
                                    data-nama="{{ $it->nama_barang }}" 
                                    data-satuan="{{ $it->satuan?->kode_satuan ?? 'Pcs' }}" 
                                    data-harga="{{ $it->harga_satuan }}">
                                {{ $it->kode_barang }} - {{ $it->nama_barang }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="form-label">Jumlah</label>
                    <input type="number" class="form-control text-end" id="quickJumlah" value="1" min="1" step="any">
                </div>
                <div>
                    <label class="form-label">Harga (Rp)</label>
                    <input type="number" class="form-control text-end" id="quickHarga" value="0" min="0">
                </div>
                <div>
                    <label class="form-label">Satuan</label>
                    <select class="form-select" id="quickSatuan">
                        @foreach($satuans as $sat)
                            <option value="{{ $sat->kode_satuan }}">{{ $sat->kode_satuan }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <button type="button" class="btn btn-success" onclick="tambahBarangRow()">
                        <i class="bi bi-plus-lg"></i> Tambah
                    </button>
                </div>
            </div>

            <!-- Table of Items (Matches User Screenshot) -->
            <div class="table-container">
                <table class="custom-table" id="tableBarang">
                    <thead>
                        <tr>
                            <th style="width: 48px; text-align: center;">No</th>
                            <th style="width: 110px;">Kode Barang</th>
                            <th>Nama Barang</th>
                            <th style="width: 120px;">Satuan</th>
                            <th style="width: 90px; text-align: right;">Jumlah</th>
                            <th style="width: 140px; text-align: right;">Harga (Rp)</th>
                            <th style="width: 150px; text-align: right;">Total (Rp)</th>
                            <th style="width: 140px;">Keterangan</th>
                            <th style="width: 90px; text-align: center;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="tbodyBarang">
                        <!-- Row 1: Besi Hollow 4x4 -->
                        <tr data-row="1">
                            <td class="row-no" style="text-align: center; color: #64748b;">1</td>
                            <td><strong style="color: #1e40af;">BRG001</strong></td>
                            <td>Besi Hollow 4x4</td>
                            <td>
                                <select class="table-select item-satuan">
                                    <option value="Pcs" selected>Pcs</option>
                                    <option value="Btg">Btg</option>
                                    <option value="Dus">Dus</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="table-input item-qty" value="10" oninput="hitungSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" class="table-input item-harga" value="85000" oninput="hitungSubtotal(this)">
                            </td>
                            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                                850.000
                            </td>
                            <td>
                                <input type="text" class="table-input" style="text-align: left;" value="-">
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 2: Semen Tiga Roda -->
                        <tr data-row="2">
                            <td class="row-no" style="text-align: center; color: #64748b;">2</td>
                            <td><strong style="color: #1e40af;">BRG002</strong></td>
                            <td>Semen Tiga Roda</td>
                            <td>
                                <select class="table-select item-satuan">
                                    <option value="Zak" selected>Zak</option>
                                    <option value="Pcs">Pcs</option>
                                    <option value="Kg">Kg</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="table-input item-qty" value="20" oninput="hitungSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" class="table-input item-harga" value="58000" oninput="hitungSubtotal(this)">
                            </td>
                            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                                1.160.000
                            </td>
                            <td>
                                <input type="text" class="table-input" style="text-align: left;" value="-">
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 3: Pasir -->
                        <tr data-row="3">
                            <td class="row-no" style="text-align: center; color: #64748b;">3</td>
                            <td><strong style="color: #1e40af;">BRG003</strong></td>
                            <td>Pasir Pasang</td>
                            <td>
                                <select class="table-select item-satuan">
                                    <option value="M3" selected>M3</option>
                                    <option value="Zak">Zak</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="table-input item-qty" value="5" oninput="hitungSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" class="table-input item-harga" value="150000" oninput="hitungSubtotal(this)">
                            </td>
                            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                                750.000
                            </td>
                            <td>
                                <input type="text" class="table-input" style="text-align: left;" value="-">
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 4: Batu Split -->
                        <tr data-row="4">
                            <td class="row-no" style="text-align: center; color: #64748b;">4</td>
                            <td><strong style="color: #1e40af;">BRG004</strong></td>
                            <td>Batu Split</td>
                            <td>
                                <select class="table-select item-satuan">
                                    <option value="M3" selected>M3</option>
                                    <option value="Zak">Zak</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="table-input item-qty" value="6" oninput="hitungSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" class="table-input item-harga" value="160000" oninput="hitungSubtotal(this)">
                            </td>
                            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                                960.000
                            </td>
                            <td>
                                <input type="text" class="table-input" style="text-align: left;" value="-">
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>

                        <!-- Row 5: Paku 7 cm -->
                        <tr data-row="5">
                            <td class="row-no" style="text-align: center; color: #64748b;">5</td>
                            <td><strong style="color: #1e40af;">BRG005</strong></td>
                            <td>Paku 7 cm</td>
                            <td>
                                <select class="table-select item-satuan">
                                    <option value="Kg" selected>Kg</option>
                                    <option value="Dus">Dus</option>
                                </select>
                            </td>
                            <td>
                                <input type="number" class="table-input item-qty" value="2" oninput="hitungSubtotal(this)">
                            </td>
                            <td>
                                <input type="number" class="table-input item-harga" value="22000" oninput="hitungSubtotal(this)">
                            </td>
                            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                                44.000
                            </td>
                            <td>
                                <input type="text" class="table-input" style="text-align: left;" value="-">
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Button Tambah Barang Lainnya -->
            <button type="button" class="btn btn-secondary" onclick="tambahBarangCustom()">
                <i class="bi bi-plus-circle"></i> Tambah Barang Lainnya
            </button>

            <!-- Bottom Action Bar & Grand Total (Matches Screenshot) -->
            <div class="action-bar-footer">
                
                <div class="action-bar-left">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-floppy-fill"></i> Simpan
                    </button>
                    <button type="button" class="btn btn-success" onclick="cetakFaktur()">
                        <i class="bi bi-printer-fill"></i> Cetak Faktur
                    </button>
                    <button type="button" class="btn btn-light" onclick="resetForm()">
                        <i class="bi bi-arrow-counterclockwise"></i> Reset
                    </button>
                    <a href="{{ route('dashboard') }}" class="btn btn-light">
                        <i class="bi bi-arrow-left"></i> Kembali
                    </a>
                </div>

                <div class="total-box">
                    <div class="total-box-label">Total Transaksi</div>
                    <div class="total-box-amount" id="grandTotalText">Rp 3.764.000</div>
                </div>

            </div>

        </div>
    </div>
</form>

@endsection

@push('scripts')
<script>
    // Copy No Transaksi ke Clipboard
    function copyNoTransaksi() {
        const noTrx = document.getElementById('noTransaksi').value;
        navigator.clipboard.writeText(noTrx).then(() => {
            alert('No. Transaksi disalin: ' + noTrx);
        });
    }

    // Auto-fill saat pilih barang di Quick Bar
    function autoFillBarang() {
        const select = document.getElementById('quickBarang');
        const selectedOpt = select.options[select.selectedIndex];
        if (selectedOpt && selectedOpt.value) {
            const harga = selectedOpt.getAttribute('data-harga') || 0;
            const satuan = selectedOpt.getAttribute('data-satuan') || 'Pcs';
            document.getElementById('quickHarga').value = harga;
            document.getElementById('quickSatuan').value = satuan;
        }
    }

    // Update info rekanan badge
    function updateRekananBadge() {
        const select = document.getElementById('selectRekanan');
        const badge = document.getElementById('rekananBadge');
        const selectedOpt = select.options[select.selectedIndex];

        if (selectedOpt && selectedOpt.value) {
            document.getElementById('badgeNamaRekanan').innerText = selectedOpt.getAttribute('data-nama');
            document.getElementById('badgeDetailRekanan').innerText = selectedOpt.getAttribute('data-kode') + ' - ' + (selectedOpt.getAttribute('data-alamat') || 'Indonesia');
            badge.style.display = 'flex';
        } else {
            badge.style.display = 'none';
        }
    }

    function clearRekanan() {
        document.getElementById('selectRekanan').value = '';
        document.getElementById('rekananBadge').style.display = 'none';
    }

    // Format Rupiah
    function formatRupiah(angka) {
        return new Intl.NumberFormat('id-ID').format(angka);
    }

    // Parse Rupiah/Number
    function parseAngka(str) {
        if (!str) return 0;
        return parseFloat(String(str).replace(/\./g, '').replace(/,/g, '.')) || 0;
    }

    // Hitung Subtotal per baris
    function hitungSubtotal(inputElem) {
        const row = inputElem.closest('tr');
        const qty = parseFloat(row.querySelector('.item-qty').value) || 0;
        const harga = parseFloat(row.querySelector('.item-harga').value) || 0;
        const subtotal = qty * harga;

        row.querySelector('.item-total').innerText = formatRupiah(subtotal);
        hitungGrandTotal();
    }

    // Hitung Grand Total Seluruh Tabel
    function hitungGrandTotal() {
        let grandTotal = 0;
        const rows = document.querySelectorAll('#tbodyBarang tr');

        rows.forEach(row => {
            const qty = parseFloat(row.querySelector('.item-qty')?.value) || 0;
            const harga = parseFloat(row.querySelector('.item-harga')?.value) || 0;
            grandTotal += (qty * harga);
        });

        document.getElementById('grandTotalText').innerText = 'Rp ' + formatRupiah(grandTotal);
    }

    // Hapus Baris
    function hapusRow(btn) {
        const row = btn.closest('tr');
        if (document.querySelectorAll('#tbodyBarang tr').length <= 1) {
            alert('Faktur harus memiliki minimal satu baris barang.');
            return;
        }
        if (confirm('Apakah Anda yakin ingin menghapus barang ini dari daftar faktur?')) {
            row.remove();
            renumberRows();
            hitungGrandTotal();
        }
    }

    // Edit Baris
    function editRow(btn) {
        const row = btn.closest('tr');
        const qtyInput = row.querySelector('.item-qty');
        qtyInput.focus();
        qtyInput.select();
    }

    // Renumber nomor baris (1, 2, 3...)
    function renumberRows() {
        const rows = document.querySelectorAll('#tbodyBarang tr');
        rows.forEach((row, index) => {
            row.querySelector('.row-no').innerText = index + 1;
        });
    }

    // Tambah barang dari Quick Add bar
    function tambahBarangRow() {
        const select = document.getElementById('quickBarang');
        const selectedOpt = select.options[select.selectedIndex];

        if (!selectedOpt || !selectedOpt.value) {
            alert('Silakan pilih barang terlebih dahulu.');
            return;
        }

        const kode = selectedOpt.value;
        const nama = selectedOpt.getAttribute('data-nama');
        const qty = parseFloat(document.getElementById('quickJumlah').value) || 1;
        const harga = parseFloat(document.getElementById('quickHarga').value) || 0;
        const satuan = document.getElementById('quickSatuan').value;
        const subtotal = qty * harga;

        const tbody = document.getElementById('tbodyBarang');
        const newRowNum = tbody.querySelectorAll('tr').length + 1;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="row-no" style="text-align: center; color: #64748b;">${newRowNum}</td>
            <td><strong style="color: #1e40af;">${kode}</strong></td>
            <td>${nama}</td>
            <td>
                <select class="table-select item-satuan">
                    <option value="${satuan}" selected>${satuan}</option>
                    <option value="Pcs">Pcs</option>
                    <option value="Zak">Zak</option>
                    <option value="M3">M3</option>
                    <option value="Kg">Kg</option>
                </select>
            </td>
            <td>
                <input type="number" class="table-input item-qty" value="${qty}" oninput="hitungSubtotal(this)">
            </td>
            <td>
                <input type="number" class="table-input item-harga" value="${harga}" oninput="hitungSubtotal(this)">
            </td>
            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                ${formatRupiah(subtotal)}
            </td>
            <td>
                <input type="text" class="table-input" style="text-align: left;" value="-">
            </td>
            <td>
                <div class="action-btn-group">
                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                    </button>
                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
        hitungGrandTotal();

        // Reset quick input
        document.getElementById('quickBarang').value = '';
        document.getElementById('quickJumlah').value = 1;
        document.getElementById('quickHarga').value = 0;
    }

    // Tambah barang kosong lainnya
    function tambahBarangCustom() {
        const tbody = document.getElementById('tbodyBarang');
        const newRowNum = tbody.querySelectorAll('tr').length + 1;

        const tr = document.createElement('tr');
        tr.innerHTML = `
            <td class="row-no" style="text-align: center; color: #64748b;">${newRowNum}</td>
            <td><strong style="color: #1e40af;">BRG00${newRowNum}</strong></td>
            <td><input type="text" class="table-input" style="text-align: left;" placeholder="Nama Barang Baru"></td>
            <td>
                <select class="table-select item-satuan">
                    <option value="Pcs" selected>Pcs</option>
                    <option value="Zak">Zak</option>
                    <option value="M3">M3</option>
                    <option value="Kg">Kg</option>
                </select>
            </td>
            <td>
                <input type="number" class="table-input item-qty" value="1" oninput="hitungSubtotal(this)">
            </td>
            <td>
                <input type="number" class="table-input item-harga" value="0" oninput="hitungSubtotal(this)">
            </td>
            <td class="text-end font-semibold item-total" style="font-weight: 700; color: #1e293b; text-align: right;">
                0
            </td>
            <td>
                <input type="text" class="table-input" style="text-align: left;" value="-">
            </td>
            <td>
                <div class="action-btn-group">
                    <button type="button" class="btn-action-edit" title="Edit Baris" onclick="editRow(this)">
                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                    </button>
                    <button type="button" class="btn-action-delete" title="Hapus Baris" onclick="hapusRow(this)">
                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                    </button>
                </div>
            </td>
        `;

        tbody.appendChild(tr);
    }

    // Reset Form
    function resetForm() {
        if (confirm('Kembalikan isian faktur ke nilai awal?')) {
            window.location.reload();
        }
    }

    // Simpan Transaksi
    function simpanTransaksi() {
        const no = document.getElementById('noTransaksi').value;
        const total = document.getElementById('grandTotalText').innerText;
        alert('Data Faktur Pembelian [' + no + '] sebesar ' + total + ' berhasil disimpan ke Database Oracle!');
    }

    // Cetak Faktur
    function cetakFaktur() {
        window.print();
    }
</script>
@endpush

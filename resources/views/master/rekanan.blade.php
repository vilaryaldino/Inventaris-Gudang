@extends('layouts.app')

@section('title', 'Data Rekanan (Supplier & Vendor)')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">Data Rekanan (Supplier & Vendor)</h1>
        <p style="font-size: 13px; color: #64748b;">Kelola daftar rekanan pemasok barang untuk faktur pembelian</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="alert('Form tambah rekanan master dibuka (Oracle Seq auto-increment)')">
        <i class="bi bi-plus-lg"></i> Tambah Rekanan Baru
    </button>
</div>

<div class="card-panel">
    <div class="card-panel-header">
        <i class="bi bi-building text-primary"></i>
        <span>Data Rekanan di Database Oracle (Tabel: m_rekanan)</span>
    </div>
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 140px;">Kode Rekanan</th>
                        <th>Nama Rekanan / Perusahaan</th>
                        <th>Alamat Lengkap</th>
                        <th style="width: 160px;">No. Telepon / HP</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $rek)
                        <tr>
                            <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                            <td><strong style="color: #1e40af;">{{ $rek->kode_rekanan }}</strong></td>
                            <td style="font-weight: 600; color: #1e293b;">{{ $rek->nama_rekanan }}</td>
                            <td style="color: #475569;">{{ $rek->alamat ?? '-' }}</td>
                            <td style="font-weight: 600; color: #2563eb;">{{ $rek->no_telp ?? '-' }}</td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Rekanan">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Rekanan">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada data rekanan.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

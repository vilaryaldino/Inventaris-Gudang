@extends('layouts.app')

@section('title', 'Master Barang (Item)')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">Master Barang (Item)</h1>
        <p style="font-size: 13px; color: #64748b;">Kelola daftar barang, satuan acuan, dan estimasi harga standar gudang</p>
    </div>
    <div style="display: flex; gap: 10px;">
        <a href="{{ route('transaksi.faktur-pembelian') }}" class="btn btn-secondary">
            <i class="bi bi-file-earmark-plus"></i> Transaksi Masuk
        </a>
        <button type="button" class="btn btn-primary" onclick="alert('Form tambah item master dibuka (Oracle Seq auto-increment)')">
            <i class="bi bi-plus-lg"></i> Tambah Barang Baru
        </button>
    </div>
</div>

<div class="card-panel">
    <div class="card-panel-header">
        <i class="bi bi-boxes text-primary"></i>
        <span>Data Barang di Database Oracle (Tabel: m_item)</span>
    </div>
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 140px;">Kode Barang</th>
                        <th>Nama Barang</th>
                        <th style="width: 140px;">Satuan Transaksi</th>
                        <th style="width: 140px;">Satuan Dasar</th>
                        <th style="width: 160px; text-align: right;">Estimasi Harga (Rp)</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $item)
                        <tr>
                            <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                            <td><strong style="color: #1e40af;">{{ $item->kode_barang }}</strong></td>
                            <td style="font-weight: 600; color: #1e293b;">{{ $item->nama_barang }}</td>
                            <td>
                                <span style="background: #eff6ff; color: #2563eb; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $item->satuan?->kode_satuan ?? '-' }}
                                </span>
                            </td>
                            <td>
                                <span style="background: #f1f5f9; color: #475569; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 500;">
                                    {{ $item->satuanDasar?->nama_satuan ?? $item->satuan?->kode_satuan }}
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Item">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Item">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada data barang.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

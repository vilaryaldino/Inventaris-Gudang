@extends('layouts.app')

@section('title', 'Master Satuan Dasar')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">Master Satuan Dasar</h1>
        <p style="font-size: 13px; color: #64748b;">Kelola satuan unit dasar terkecil di gudang (Pieces, Kilogram, Meter, dll)</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="alert('Form tambah satuan dasar dibuka')">
        <i class="bi bi-plus-lg"></i> Tambah Satuan Dasar
    </button>
</div>

<div class="card-panel">
    <div class="card-panel-header">
        <i class="bi bi-rulers text-primary"></i>
        <span>Data Satuan Dasar di Database Oracle (Tabel: m_satuan_dasar)</span>
    </div>
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 150px;">Kode Satuan Dasar</th>
                        <th>Nama Satuan Dasar</th>
                        <th style="width: 180px; text-align: center;">Jumlah Satuan Turunan</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $sd)
                        <tr>
                            <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                            <td><strong style="color: #1e40af;">{{ $sd->kode_satuan }}</strong></td>
                            <td style="font-weight: 600; color: #1e293b;">{{ $sd->nama_satuan }}</td>
                            <td style="text-align: center;">
                                <span style="background: #ecfdf5; color: #065f46; padding: 4px 10px; border-radius: 9999px; font-size: 12px; font-weight: 700;">
                                    {{ $sd->satuan_count ?? 0 }} Konversi
                                </span>
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada data satuan dasar.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

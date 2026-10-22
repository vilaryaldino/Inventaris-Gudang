@extends('layouts.app')

@section('title', 'Master Satuan Konversi')

@section('content')
<div style="display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px;">
    <div>
        <h1 style="font-size: 20px; font-weight: 700; color: #0f172a;">Master Satuan Konversi</h1>
        <p style="font-size: 13px; color: #64748b;">Kelola satuan transaksi beserta faktor konversi ke satuan dasar</p>
    </div>
    <button type="button" class="btn btn-primary" onclick="alert('Form tambah satuan konversi dibuka')">
        <i class="bi bi-plus-lg"></i> Tambah Satuan Baru
    </button>
</div>

<div class="card-panel">
    <div class="card-panel-header">
        <i class="bi bi-stack text-primary"></i>
        <span>Data Satuan Konversi di Database Oracle (Tabel: m_satuan)</span>
    </div>
    <div class="card-panel-body" style="padding: 0;">
        <div class="table-container" style="border: none; margin-bottom: 0;">
            <table class="custom-table">
                <thead>
                    <tr>
                        <th style="width: 50px; text-align: center;">No</th>
                        <th style="width: 130px;">Kode Satuan</th>
                        <th>Nama Satuan</th>
                        <th style="width: 180px;">Satuan Dasar (Induk)</th>
                        <th style="width: 150px; text-align: right;">Nilai Konversi</th>
                        <th style="width: 120px; text-align: center;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($data as $index => $sat)
                        <tr>
                            <td style="text-align: center; color: #64748b;">{{ $index + 1 }}</td>
                            <td><strong style="color: #1e40af;">{{ $sat->kode_satuan }}</strong></td>
                            <td style="font-weight: 600; color: #1e293b;">{{ $sat->nama_satuan }}</td>
                            <td>
                                <span style="background: #f1f5f9; color: #334155; padding: 4px 10px; border-radius: 6px; font-size: 12px; font-weight: 600;">
                                    {{ $sat->satuanDasar?->nama_satuan ?? '-' }} ({{ $sat->satuanDasar?->kode_satuan ?? '-' }})
                                </span>
                            </td>
                            <td style="text-align: right; font-weight: 700; color: #0f172a;">
                                {{ number_format($sat->konversi, 4, ',', '.') }}
                            </td>
                            <td>
                                <div class="action-btn-group">
                                    <button type="button" class="btn-action-edit" title="Edit Satuan">
                                        <i class="bi bi-pencil-fill" style="font-size: 11px;"></i>
                                    </button>
                                    <button type="button" class="btn-action-delete" title="Hapus Satuan">
                                        <i class="bi bi-trash-fill" style="font-size: 11px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 30px; color: #94a3b8;">Belum ada data satuan konversi.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

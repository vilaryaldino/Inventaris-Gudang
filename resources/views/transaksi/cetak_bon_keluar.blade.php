<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bukti Barang Keluar - {{ $trx->no_transaksi }}</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }
        body {
            font-family: 'Plus Jakarta Sans', Arial, sans-serif;
            font-size: 13px;
            color: #1e293b;
            background-color: #f1f5f9;
            padding: 30px;
            line-height: 1.5;
        }
        .invoice-box {
            max-width: 900px;
            margin: auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.08);
            border: 1px solid #e2e8f0;
            position: relative;
        }
        .header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
            margin-bottom: 24px;
        }
        .company-info h1 {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.5px;
        }
        .company-info p {
            font-size: 12px;
            color: #64748b;
            line-height: 1.5;
            margin-top: 4px;
        }
        .invoice-title {
            text-align: right;
        }
        .invoice-title h2 {
            font-size: 18px;
            color: #dc2626;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }
        .invoice-title .badge {
            display: inline-block;
            background: #fef2f2;
            color: #b91c1c;
            border: 1px solid #fecaca;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 800;
            margin-top: 6px;
            font-size: 14px;
            font-family: ui-monospace, SFMono-Regular, monospace;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1.2fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 18px 22px;
            border-radius: 8px;
            border: 1px solid #e2e8f0;
        }
        .meta-col p {
            margin-bottom: 7px;
            display: flex;
        }
        .meta-col p:last-child {
            margin-bottom: 0;
        }
        .meta-label {
            width: 140px;
            color: #64748b;
            font-weight: 500;
            font-size: 12.5px;
            flex-shrink: 0;
        }
        .meta-value {
            color: #0f172a;
            font-weight: 600;
            font-size: 12.5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th {
            background-color: #f8fafc;
            color: #475569;
            text-align: left;
            padding: 10px 12px;
            font-size: 11.5px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.04em;
            border-bottom: 2px solid #cbd5e1;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
            color: #1e293b;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: 700; }
        .total-row td {
            font-weight: 800;
            font-size: 13px;
            color: #0f172a;
            border-top: 2px solid #cbd5e1;
            background: #f8fafc;
            padding: 12px;
        }
        .note-box {
            margin-bottom: 24px;
            font-size: 12.5px;
            color: #334155;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 12px 16px;
            border-radius: 8px;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 36px;
            text-align: center;
        }
        .sign-box p {
            font-size: 12px;
            color: #475569;
            font-weight: 600;
        }
        .sign-space {
            height: 65px;
        }
        .sign-name {
            font-weight: 700;
            border-top: 1px solid #94a3b8;
            display: inline-block;
            min-width: 170px;
            padding-top: 4px;
            font-size: 12px;
        }
        .no-print {
            max-width: 900px;
            margin: 0 auto 16px auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .btn-print {
            background: linear-gradient(180deg, #2563eb 0%, #1d4ed8 100%);
            color: #ffffff;
            border: none;
            padding: 9px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
            box-shadow: 0 2px 6px rgba(37, 99, 235, 0.25);
        }
        .btn-close {
            background: #ffffff;
            color: #475569;
            border: 1px solid #cbd5e1;
            padding: 9px 18px;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                border: none;
                padding: 0;
            }
            .no-print {
                display: none !important;
            }
        }
    </style>
</head>
<body>

    <div class="no-print">
        <span style="font-size: 13px; color: #64748b; font-weight: 500;">
            Dokumen Cetak Bukti Barang Keluar &middot; Oracle 11g Verified
        </span>
        <div style="display: flex; gap: 8px;">
            <button class="btn-print" onclick="window.print()">🖨️ Cetak Dokumen</button>
            <button class="btn-close" onclick="window.close()">Tutup</button>
        </div>
    </div>

    <div class="invoice-box">
        <div class="header">
            <div class="company-info">
                <h1>PT USAHA BAKTI PERKASA</h1>
                <p>
                    Divisi Gudang &amp; Logistik Material<br>
                    Sistem Manajemen Pergudangan Enterprise Terpadu
                </p>
            </div>
            <div class="invoice-title">
                <h2>BUKTI BARANG KELUAR</h2>
                <div class="badge">{{ $trx->no_transaksi }}</div>
            </div>
        </div>

        <div class="meta-grid">
            <div class="meta-col">
                <p>
                    <span class="meta-label">Untuk Project / IKI:</span>
                    <span class="meta-value" style="color: #2563eb;">
                        {{ $trx->project ? $trx->project->kd_project : '-' }}
                    </span>
                </p>
                <p>
                    <span class="meta-label">Nama Project:</span>
                    <span class="meta-value">
                        {{ $trx->project ? $trx->project->nm_project : 'Umum / Non-Project' }}
                    </span>
                </p>
                <p>
                    <span class="meta-label">Sub-Contractor:</span>
                    <span class="meta-value">{{ $trx->subkon_pakai ?? '-' }}</span>
                </p>
                <p>
                    <span class="meta-label">No. Cutting Plan:</span>
                    <span class="meta-value">{{ $trx->no_cutting ?? '-' }}</span>
                </p>
            </div>
            <div class="meta-col">
                <p>
                    <span class="meta-label">Tanggal Pengeluaran:</span>
                    <span class="meta-value">{{ $trx->tgl_transaksi ? \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d F Y') : '-' }}</span>
                </p>
                <p>
                    <span class="meta-label">ID Transaksi Oracle:</span>
                    <span class="meta-value" style="font-family: monospace;">{{ $trx->id_transaksi }}</span>
                </p>
                <p>
                    <span class="meta-label">Petugas Input:</span>
                    <span class="meta-value">{{ $trx->opr_insert ?? 'ADMIN' }}</span>
                </p>
                <p>
                    <span class="meta-label">Waktu Input:</span>
                    <span class="meta-value">{{ $trx->tgl_insert ? \Carbon\Carbon::parse($trx->tgl_insert)->format('d/m/Y H:i') : '-' }}</span>
                </p>
            </div>
        </div>

        @if($trx->keterangan)
        <div class="note-box">
            <strong>Note / Catatan:</strong> {{ $trx->keterangan }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">No</th>
                    <th style="width: 100px;">Kode</th>
                    <th>Nama Barang</th>
                    <th class="text-right" style="width: 90px;">Jumlah</th>
                    <th class="text-center" style="width: 70px;">Satuan</th>
                    <th style="width: 110px;">Asal Stok</th>
                    <th style="width: 110px;">No. IKI</th>
                    <th style="width: 100px;">Heat No</th>
                    <th>Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trx->details as $d)
                <tr>
                    <td class="text-center" style="color: #64748b;">{{ $d->no_urut }}</td>
                    <td><strong style="color: #1e40af; font-family: ui-monospace, monospace;">{{ $d->barang ? $d->barang->kode_barang : "BRG-{$d->id_barang}" }}</strong></td>
                    <td><strong>{{ $d->barang ? $d->barang->nama_barang : "Barang ID {$d->id_barang}" }}</strong></td>
                    <td class="text-right font-bold" style="color: #0f172a;">{{ number_format($d->jumlah, 2, ',', '.') }}</td>
                    <td class="text-center">{{ $d->satuan ? $d->satuan->nama_satuan : ($d->barang?->satuan?->nama_satuan ?? '-') }}</td>
                    <td>{{ $d->asal_stok ?? 'Stok Project' }}</td>
                    <td>{{ $d->project ? $d->project->kd_project : ($trx->project?->kd_project ?? '-') }}</td>
                    <td>{{ $d->heat_no ?? '-' }}</td>
                    <td>{{ $d->keterangan ?? '-' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="9" class="text-center" style="color: #94a3b8; padding: 24px;">Tidak ada rincian barang.</td>
                </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="3" class="text-right">TOTAL KUANTITAS DIKELUARKAN:</td>
                    <td class="text-right" style="color: #2563eb;">{{ number_format($trx->total_kuantitas, 2, ',', '.') }}</td>
                    <td colspan="5"></td>
                </tr>
            </tbody>
        </table>

        <div class="signatures">
            <div class="sign-box">
                <p>Dibuat / Dikeluarkan Oleh,</p>
                <div class="sign-space"></div>
                <div class="sign-name">( {{ $trx->opr_insert ?? 'Petugas Gudang' }} )</div>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Petugas Gudang</p>
            </div>
            <div class="sign-box">
                <p>Diterima Oleh,</p>
                <div class="sign-space"></div>
                <div class="sign-name">( {{ $trx->subkon_pakai ?: 'Penerima / Subkon' }} )</div>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Sub-Kontraktor / Pemohon</p>
            </div>
            <div class="sign-box">
                <p>Mengetahui / Disetujui,</p>
                <div class="sign-space"></div>
                <div class="sign-name">( Kepala Gudang )</div>
                <p style="font-size: 11px; color: #94a3b8; margin-top: 2px;">Supervisor / Logistik</p>
            </div>
        </div>
    </div>

</body>
</html>


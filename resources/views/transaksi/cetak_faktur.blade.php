<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cetak Faktur Penerimaan - {{ $trx->no_transaksi }}</title>
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
        }
        .invoice-box {
            max-width: 850px;
            margin: auto;
            background: #ffffff;
            padding: 36px 40px;
            border-radius: 8px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
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
            color: #2563eb;
            font-weight: 800;
            text-transform: uppercase;
        }
        .invoice-title .badge {
            display: inline-block;
            background: #eff6ff;
            color: #1d4ed8;
            border: 1px solid #bfdbfe;
            padding: 4px 10px;
            border-radius: 4px;
            font-weight: 700;
            margin-top: 6px;
            font-size: 13px;
        }
        .meta-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
            margin-bottom: 24px;
            background: #f8fafc;
            padding: 16px 20px;
            border-radius: 6px;
            border: 1px solid #e2e8f0;
        }
        .meta-col p {
            margin-bottom: 6px;
            display: flex;
        }
        .meta-col p:last-child {
            margin-bottom: 0;
        }
        .meta-label {
            width: 140px;
            color: #64748b;
            font-weight: 500;
        }
        .meta-value {
            flex: 1;
            font-weight: 600;
            color: #0f172a;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 24px;
        }
        th {
            background-color: #f1f5f9;
            color: #475569;
            text-align: left;
            padding: 10px 12px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            border-bottom: 2px solid #cbd5e1;
        }
        td {
            padding: 10px 12px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 12px;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .total-row td {
            font-weight: 800;
            font-size: 14px;
            color: #0f172a;
            border-top: 2px solid #cbd5e1;
            background: #f8fafc;
        }
        .signatures {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 20px;
            margin-top: 40px;
            text-align: center;
        }
        .sign-box {
            padding-top: 10px;
        }
        .sign-space {
            height: 70px;
        }
        .sign-name {
            font-weight: 700;
            border-top: 1px solid #94a3b8;
            display: inline-block;
            min-width: 160px;
            padding-top: 6px;
        }
        .no-print {
            margin-bottom: 20px;
            text-align: right;
        }
        .btn {
            background: #2563eb;
            color: #ffffff;
            border: none;
            padding: 9px 18px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: 600;
            font-size: 13px;
        }
        .btn-secondary {
            background: #64748b;
            margin-left: 8px;
        }
        @media print {
            body {
                background: #ffffff;
                padding: 0;
            }
            .invoice-box {
                box-shadow: none;
                padding: 0;
            }
            .no-print {
                display: none;
            }
        }
    </style>
</head>
<body>

    <div class="invoice-box">
        <div class="no-print">
            <button class="btn" onclick="window.print()">🖨️ Cetak Dokumen</button>
            <button class="btn btn-secondary" onclick="window.close()">Tutup</button>
        </div>

        <div class="header">
            <div class="company-info">
                <h1>PT. LOGISTIK WAREHOUSE INDONESIA</h1>
                <p>Kawasan Industri Terpadu Blok D-12, Cikarang, Jawa Barat<br>
                Telp: (021) 8983-4000 | Email: warehouse@logistik-indonesia.co.id</p>
            </div>
            <div class="invoice-title">
                <h2>Bukti Penerimaan Barang</h2>
                <div class="badge">{{ $trx->no_transaksi }}</div>
            </div>
        </div>

        <div class="meta-grid">
            <div class="meta-col">
                <p><span class="meta-label">No. Transaksi</span><span class="meta-value">{{ $trx->no_transaksi }} (ID: {{ $trx->id_transaksi }})</span></p>
                <p><span class="meta-label">Tanggal Masuk</span><span class="meta-value">{{ $trx->tgl_transaksi ? \Carbon\Carbon::parse($trx->tgl_transaksi)->format('d F Y') : '-' }}</span></p>
                <p><span class="meta-label">No. Surat Jalan</span><span class="meta-value">{{ $trx->no_sj ?? '-' }}</span></p>
                <p><span class="meta-label">Tgl. Surat Jalan</span><span class="meta-value">{{ $trx->tgl_sj ? \Carbon\Carbon::parse($trx->tgl_sj)->format('d F Y') : '-' }}</span></p>
            </div>
            <div class="meta-col">
                <p><span class="meta-label">Pemasok / Vendor</span><span class="meta-value">{{ $trx->rekanan ? $trx->rekanan->nama_rekanan : "Rekanan ID {$trx->id_rekanan}" }}</span></p>
                <p><span class="meta-label">Kode Vendor</span><span class="meta-value">{{ $trx->rekanan ? $trx->rekanan->kode_rekanan : '-' }}</span></p>
                <p><span class="meta-label">Operator Gudang</span><span class="meta-value">{{ $trx->opr_insert ?? 'SYSTEM' }}</span></p>
                <p><span class="meta-label">Waktu Input</span><span class="meta-value">{{ $trx->tgl_insert ? \Carbon\Carbon::parse($trx->tgl_insert)->format('d/m/Y H:i') : '-' }}</span></p>
            </div>
        </div>

        @if($trx->keterangan)
        <div style="margin-bottom: 20px; font-size: 12px; color: #475569; background: #fffbeb; border: 1px solid #fef3c7; padding: 10px 14px; border-radius: 6px;">
            <strong>Catatan:</strong> {{ $trx->keterangan }}
        </div>
        @endif

        <table>
            <thead>
                <tr>
                    <th class="text-center" style="width: 40px;">No</th>
                    <th style="width: 100px;">Kode Barang</th>
                    <th>Nama Barang</th>
                    <th class="text-center" style="width: 90px;">Satuan</th>
                    <th class="text-right" style="width: 80px;">Jumlah</th>
                    <th class="text-right" style="width: 120px;">Harga Satuan</th>
                    <th class="text-right" style="width: 140px;">Subtotal (Rp)</th>
                </tr>
            </thead>
            <tbody>
                @forelse($trx->details as $d)
                <tr>
                    <td class="text-center">{{ $d->no_urut }}</td>
                    <td><strong>{{ $d->barang ? $d->barang->kode_barang : "BRG-{$d->id_barang}" }}</strong></td>
                    <td>{{ $d->barang ? $d->barang->nama_barang : "Barang ID {$d->id_barang}" }}</td>
                    <td class="text-center">{{ $d->satuan ? $d->satuan->nama_satuan : "Satuan {$d->id_satuan}" }}</td>
                    <td class="text-right">{{ number_format($d->jumlah, 2, ',', '.') }}</td>
                    <td class="text-right">{{ $d->barang ? number_format($d->barang->harga_satuan, 0, ',', '.') : '-' }}</td>
                    <td class="text-right font-bold">{{ number_format($d->total, 0, ',', '.') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" class="text-center" style="color: #94a3b8; padding: 20px;">Tidak ada rincian barang.</td>
                </tr>
                @endforelse
                <tr class="total-row">
                    <td colspan="4" class="text-right">GRAND TOTAL</td>
                    <td class="text-right">{{ number_format($trx->total_kuantitas, 2, ',', '.') }}</td>
                    <td></td>
                    <td class="text-right">Rp {{ number_format($trx->total_nilai, 0, ',', '.') }}</td>
                </tr>
            </tbody>
        </table>

        <div class="signatures">
            <div class="sign-box">
                <p>Pengirim / Kurir</p>
                <div class="sign-space"></div>
                <span class="sign-name">( ........................................ )</span>
            </div>
            <div class="sign-box">
                <p>Diterima Oleh Petugas</p>
                <div class="sign-space"></div>
                <span class="sign-name">{{ $trx->opr_insert ?? 'Petugas Gudang' }}</span>
            </div>
            <div class="sign-box">
                <p>Mengetahui Kepala Gudang</p>
                <div class="sign-space"></div>
                <span class="sign-name">( ........................................ )</span>
            </div>
        </div>
    </div>

</body>
</html>

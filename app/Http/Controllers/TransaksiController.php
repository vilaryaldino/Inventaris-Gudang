<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GdTerimaBeliM;
use App\Models\GdTerimaBeliD;
use App\Models\PmbPurchorderM;
use App\Models\PmbPurchorderD;
use App\Models\MItem;
use App\Models\MSatuan;
use App\Models\MSatuanDasar;
use App\Models\MRekanan;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TransaksiController extends Controller
{
    /**
     * Halaman Utama Faktur Pembelian (Penerimaan Barang).
     * Menyediakan tab daftar transaksi (dengan filter & pagination)
     * dan tab formulir pembuatan transaksi baru.
     */
    public function fakturPembelian(Request $request)
    {
        // 1. Data Filter & Pencarian
        $query = GdTerimaBeliM::with(['rekanan', 'po', 'details.barang', 'details.satuan']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('no_transaksi', 'LIKE', "%{$q}%")
                    ->orWhere('no_sj', 'LIKE', "%{$q}%")
                    ->orWhere('no_po', 'LIKE', "%{$q}%")
                    ->orWhere('keterangan', 'LIKE', "%{$q}%")
                    ->orWhereHas('rekanan', function ($r) use ($q) {
                        $r->where('nama_rekanan', 'LIKE', "%{$q}%")
                          ->orWhere('kode_rekanan', 'LIKE', "%{$q}%");
                    })
                    ->orWhereHas('po', function ($p) use ($q) {
                        $p->where('no_transaksi', 'LIKE', "%{$q}%");
                    });
            });
        }

        if ($request->filled('id_rekanan')) {
            $query->where('id_rekanan', $request->id_rekanan);
        }

        if ($request->filled('tgl_mulai')) {
            try {
                $tglMulai = Carbon::parse($request->tgl_mulai)->startOfDay()->format('Y-m-d H:i:s');
                $query->where('tgl_transaksi', '>=', $tglMulai);
            } catch (\Throwable $e) {}
        }

        if ($request->filled('tgl_selesai')) {
            try {
                $tglSelesai = Carbon::parse($request->tgl_selesai)->endOfDay()->format('Y-m-d H:i:s');
                $query->where('tgl_transaksi', '<=', $tglSelesai);
            } catch (\Throwable $e) {}
        }

        // 2. Transaksi Terdaftar (Pagination 10 per halaman)
        $transaksiList = $query->orderBy('id_transaksi', 'desc')->paginate(10)->withQueryString();

        // 3. Statistik Ringkasan untuk KPI Cards
        $totalTransaksi = GdTerimaBeliM::count();
        $totalQtyBarang = (float) GdTerimaBeliD::where('is_stok', 'Y')->sum('jumlah');
        $totalNilaiFaktur = (float) GdTerimaBeliD::sum('total');

        // 4. Data Master & Simulasi Purchase Order untuk Formulir Input
        $rekanans = MRekanan::orderBy('nama_rekanan')->get();
        $items = MItem::with(['satuan.satuanDasar'])->orderBy('kode_barang')->get();
        $satuans = MSatuan::orderBy('kode_satuan')->get();

        // Ambil daftar Purchase Order yang memiliki item barang di pmb_purchorder_d
        $poList = PmbPurchorderM::with(['rekanan'])
            ->has('details')
            ->orderBy('id_transaksi', 'desc')
            ->take(50)
            ->get();

        // 5. Generate Nomor Transaksi Preview
        $todayStr = Carbon::now()->format('ym');
        $previewCounter = str_pad($totalTransaksi + 1, 5, '0', STR_PAD_LEFT);
        $noTransaksiPreview = 'TB' . $todayStr . $previewCounter;

        $tglTransaksi = Carbon::now()->format('d/m/Y');
        $tglInsert = Carbon::now()->format('d/m/Y H:i');

        // Tab aktif (default 'list' atau 'create')
        $activeTab = $request->get('tab', 'list');

        return view('transaksi.faktur_pembelian', compact(
            'transaksiList',
            'totalTransaksi',
            'totalQtyBarang',
            'totalNilaiFaktur',
            'rekanans',
            'items',
            'satuans',
            'poList',
            'noTransaksiPreview',
            'tglTransaksi',
            'tglInsert',
            'activeTab'
        ));
    }

    /**
     * Ambil data Purchase Order (Header + Detail Barang) via AJAX.
     * Digunakan untuk auto-populate form penerimaan gudang.
     */
    public function getPurchaseOrder(Request $request, $id)
    {
        $query = PmbPurchorderM::with([
            'rekanan',
            'details.barang.satuan',
            'details.satuan',
        ]);

        if (is_numeric($id)) {
            $po = $query->where('id_transaksi', $id)->first();
        } else {
            $po = $query->where('no_transaksi', $id)->first();
        }

        if (!$po) {
            return response()->json([
                'success' => false,
                'message' => "Purchase Order [{$id}] tidak ditemukan di database Oracle.",
            ], 404);
        }

        if ($po->details->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => "Purchase Order [{$po->no_transaksi}] tidak memiliki detail item barang untuk diproses.",
            ], 422);
        }

        $poDetails = $po->details->map(function ($d) {
            // Hitung akumulasi qty yang sudah pernah diterima untuk item detail PO ini
            $sudahDiterima = (float) GdTerimaBeliD::where('id_po_detail', $d->id_detail)->sum('jumlah');
            $sisaQty = max(0, (float) $d->jumlah - $sudahDiterima);

            return [
                'id_detail' => (int) $d->id_detail,
                'no_urut' => (int) $d->no_urut,
                'id_barang' => (int) $d->id_barang,
                'kode_barang' => $d->barang ? $d->barang->kode_barang : "BRG-{$d->id_barang}",
                'nama_barang' => $d->barang ? $d->barang->nama_barang : "Barang #{$d->id_barang}",
                'id_satuan' => (int) $d->id_satuan,
                'nama_satuan' => $d->satuan ? $d->satuan->nama_satuan : ($d->barang?->satuan?->nama_satuan ?? 'Pcs'),
                'qty_po' => (float) $d->jumlah,
                'sudah_diterima' => $sudahDiterima,
                'sisa_qty' => $sisaQty,
                'harga' => (float) $d->harga,
                'total' => (float) ($sisaQty > 0 ? ($sisaQty * (float) $d->harga) : $d->total),
            ];
        });

        return response()->json([
            'success' => true,
            'data' => [
                'id_transaksi' => $po->id_transaksi,
                'no_transaksi' => $po->no_transaksi,
                'tgl_transaksi' => $po->tgl_transaksi ? Carbon::parse($po->tgl_transaksi)->format('d/m/Y') : '-',
                'id_rekanan' => $po->id_rekanan,
                'rekanan' => [
                    'id' => $po->rekanan ? $po->rekanan->id : $po->id_rekanan,
                    'nama' => $po->rekanan ? $po->rekanan->nama_rekanan : "Pemasok #{$po->id_rekanan}",
                    'kode' => $po->rekanan ? $po->rekanan->kode_rekanan : '-',
                    'alamat' => $po->rekanan ? $po->rekanan->alamat : 'Alamat tidak terdata',
                    'no_telp' => $po->rekanan ? $po->rekanan->no_telp : '-',
                ],
                'keterangan' => $po->keterangan,
                'items' => $poDetails,
                'total_items' => $poDetails->count(),
                'total_qty_po' => (float) $po->total_qty,
                'total_nilai_po' => (float) $po->total_nilai,
            ]
        ]);
    }

    /**
     * Simpan Transaksi Penerimaan Pembelian Baru.
     * Menggunakan data dari PO: User TIDAK BOLEH menambah item di luar PO.
     * Validasi backend memastikan item yang disimpan valid dan berasal dari PO tersebut.
     */
    public function storeFakturPembelian(Request $request)
    {
        // 1. Validasi Input Server-Side
        $validated = $request->validate([
            'no_transaksi' => 'nullable|string|max:50',
            'tgl_transaksi' => 'required',
            'id_po' => 'required|integer',
            'no_sj' => 'nullable|string|max:50',
            'tgl_sj' => 'nullable',
            'keterangan' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id_po_detail' => 'required|integer',
            'items.*.jumlah' => 'required|numeric|min:0.0001',
        ], [
            'id_po.required' => 'Nomor Purchase Order (PO) wajib dipilih.',
            'items.required' => 'Daftar barang penerimaan PO tidak boleh kosong.',
            'items.min' => 'Faktur harus berisi minimal 1 item barang yang diterima.',
            'items.*.id_po_detail.required' => 'Referensi item PO tidak valid.',
            'items.*.jumlah.required' => 'Kuantitas barang yang diterima wajib diisi.',
            'items.*.jumlah.min' => 'Kuantitas barang yang diterima harus lebih besar dari 0.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Ambil Data PO dan Detail Terkait untuk Validasi Keamanan Backend
            $po = PmbPurchorderM::with('details')->findOrFail($request->id_po);
            $poDetailsMap = $po->details->keyBy('id_detail');

            // 3. Validasi Integritas Bisnis: Pastikan SEMUA item yang dikirim berasal dari PO ini!
            foreach ($request->items as $idx => $itemData) {
                $poDetailId = (int) $itemData['id_po_detail'];

                if (!$poDetailsMap->has($poDetailId)) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Pelanggaran Aturan Bisnis: Baris ke-" . ($idx + 1) . " (Detail ID: {$poDetailId}) bukan bagian dari Purchase Order [{$po->no_transaksi}]. Penambahan barang di luar PO dilarang!",
                    ], 422);
                }

                $poDetail = $poDetailsMap->get($poDetailId);
                $qtyDiterima = (float) $itemData['jumlah'];
                $qtyMaksimal = (float) $poDetail->jumlah;

                if ($qtyDiterima > $qtyMaksimal) {
                    DB::rollBack();
                    return response()->json([
                        'success' => false,
                        'message' => "Kuantitas diterima ({$qtyDiterima}) pada baris ke-" . ($idx + 1) . " melebihi pesanan PO ({$qtyMaksimal}). Penerimaan tidak boleh melebihi kuantitas PO!",
                    ], 422);
                }
            }

            // 4. Ambil Sequence ID untuk Header dari Oracle SEQ_GD_TERIMA_M
            $seqHeader = DB::selectOne("SELECT SEQ_GD_TERIMA_M.NEXTVAL as val FROM DUAL");
            $idTransaksi = (int) $seqHeader->val;

            // 5. Format Tanggal
            $tglTransaksi = Carbon::hasFormat($request->tgl_transaksi, 'd/m/Y')
                ? Carbon::createFromFormat('d/m/Y', $request->tgl_transaksi)->format('Y-m-d H:i:s')
                : Carbon::parse($request->tgl_transaksi)->format('Y-m-d H:i:s');

            $tglSj = null;
            if ($request->filled('tgl_sj')) {
                $tglSj = Carbon::hasFormat($request->tgl_sj, 'd/m/Y')
                    ? Carbon::createFromFormat('d/m/Y', $request->tgl_sj)->format('Y-m-d H:i:s')
                    : Carbon::parse($request->tgl_sj)->format('Y-m-d H:i:s');
            } else {
                $tglSj = $tglTransaksi;
            }

            // 6. Nomor Transaksi Otomatis
            $noCounter = str_pad($idTransaksi, 5, '0', STR_PAD_LEFT);
            $noTransaksi = $request->filled('no_transaksi') && $request->no_transaksi !== '-'
                ? trim($request->no_transaksi)
                : 'TB' . Carbon::now()->format('ym') . $noCounter;

            $cekNo = DB::table('gd_terima_beli_m')->where('no_transaksi', $noTransaksi)->exists();
            if ($cekNo) {
                $noTransaksi = 'TB' . Carbon::now()->format('ym') . $noCounter . '-' . $idTransaksi;
            }

            $nowStr = Carbon::now()->format('Y-m-d H:i:s');
            $operator = auth()->check() ? auth()->user()->name : 'SYSTEM';

            // 7. Simpan Header (gd_terima_beli_m)
            DB::table('gd_terima_beli_m')->insert([
                'id_transaksi' => $idTransaksi,
                'no_transaksi' => $noTransaksi,
                'no_transaksi_kode' => 'TB',
                'no_transaksi_counter' => $noCounter,
                'jns_transaksi' => '03',
                'tgl_transaksi' => $tglTransaksi,
                'no_sj' => $request->filled('no_sj') ? trim($request->no_sj) : '-',
                'tgl_sj' => $tglSj,
                'id_rekanan' => $po->id_rekanan,
                'id_po' => $po->id_transaksi,
                'no_po' => $po->no_transaksi,
                'keterangan' => $request->keterangan,
                'tgl_insert' => $nowStr,
                'opr_insert' => $operator,
            ]);

            // 8. Simpan Detail Barang (gd_terima_beli_d)
            $noUrut = 1;
            foreach ($request->items as $itemData) {
                $poDetail = $poDetailsMap->get((int) $itemData['id_po_detail']);
                $jumlah = (float) $itemData['jumlah'];

                // Harga dikunci server-side dari PO asli demi keamanan finansial
                $hargaSatuan = (float) $poDetail->harga;
                $totalNilai = $jumlah * $hargaSatuan;

                // Ambil Sequence ID untuk Detail dari Oracle SEQ_GD_TERIMA_D
                $seqDetail = DB::selectOne("SELECT SEQ_GD_TERIMA_D.NEXTVAL as val FROM DUAL");
                $idDetail = (int) $seqDetail->val;

                DB::table('gd_terima_beli_d')->insert([
                    'id_detail' => $idDetail,
                    'id_transaksi' => $idTransaksi,
                    'no_urut' => $noUrut,
                    'id_barang' => (int) $poDetail->id_barang,
                    'id_satuan' => (int) $poDetail->id_satuan,
                    'jumlah' => $jumlah,
                    'total' => $totalNilai,
                    'tgl_dibutuhkan' => $poDetail->tgl_dibutuhkan,
                    'is_project' => $poDetail->is_project ?? 'N',
                    'id_project' => $poDetail->id_project,
                    'id_po' => $po->id_transaksi,
                    'id_po_detail' => $poDetail->id_detail,
                    'jumlah2' => $poDetail->jumlah2,
                    'id_satuan2' => $poDetail->id_satuan2,
                    'id_pesan' => $poDetail->id_pesan,
                    'is_stok' => 'Y',
                    'lokasi_gdg' => null,
                ]);

                $noUrut++;
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Faktur Penerimaan [{$noTransaksi}] dari PO [{$po->no_transaksi}] berhasil disimpan ke Oracle Database! (ID: {$idTransaksi})",
                    'id_transaksi' => $idTransaksi,
                    'no_transaksi' => $noTransaksi,
                ]);
            }

            return redirect()->route('transaksi.faktur-pembelian')
                ->with('success', "Faktur Penerimaan [{$noTransaksi}] dari PO [{$po->no_transaksi}] berhasil disimpan dengan ID Transaksi: {$idTransaksi}.");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal simpan faktur pembelian: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Terjadi kesalahan sistem saat menyimpan transaksi: ' . $e->getMessage(),
                ], 500);
            }

            return back()->withInput()->with('error', 'Gagal menyimpan transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Tampilkan Detail Transaksi Penerimaan.
     * Mengembalikan data JSON untuk Modal atau View lengkap.
     */
    public function showFakturPembelian(Request $request, $id)
    {
        $trx = GdTerimaBeliM::with(['rekanan', 'po', 'details.barang', 'details.satuan'])
            ->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id_transaksi' => $trx->id_transaksi,
                    'no_transaksi' => $trx->no_transaksi,
                    'tgl_transaksi' => $trx->tgl_transaksi ? Carbon::parse($trx->tgl_transaksi)->format('d/m/Y') : '-',
                    'id_po' => $trx->id_po,
                    'no_po' => $trx->po ? $trx->po->no_transaksi : ($trx->no_po ?? ($trx->id_po ? "PO #{$trx->id_po}" : '-')),
                    'no_sj' => $trx->no_sj ?? '-',
                    'tgl_sj' => $trx->tgl_sj ? Carbon::parse($trx->tgl_sj)->format('d/m/Y') : '-',
                    'opr_insert' => $trx->opr_insert,
                    'tgl_insert' => $trx->tgl_insert ? Carbon::parse($trx->tgl_insert)->format('d/m/Y H:i') : '-',
                    'keterangan' => $trx->keterangan ?? '-',
                    'rekanan' => [
                        'nama' => $trx->rekanan ? $trx->rekanan->nama_rekanan : "Rekanan ID {$trx->id_rekanan}",
                        'kode' => $trx->rekanan ? $trx->rekanan->kode_rekanan : '-',
                        'alamat' => $trx->rekanan ? $trx->rekanan->alamat : '-',
                        'no_telp' => $trx->rekanan ? $trx->rekanan->no_telp : '-',
                    ],
                    'items' => $trx->details->map(function ($d) {
                        return [
                            'id_detail' => $d->id_detail,
                            'id_po_detail' => $d->id_po_detail,
                            'no_urut' => $d->no_urut,
                            'kode_barang' => $d->barang ? $d->barang->kode_barang : "BRG-{$d->id_barang}",
                            'nama_barang' => $d->barang ? $d->barang->nama_barang : "Barang #{$d->id_barang}",
                            'satuan' => $d->satuan ? $d->satuan->nama_satuan : "Satuan #{$d->id_satuan}",
                            'jumlah' => (float) $d->jumlah,
                            'harga_satuan' => $d->barang ? (float) $d->barang->harga_satuan : 0,
                            'total' => (float) $d->total,
                            'is_stok' => $d->is_stok,
                        ];
                    }),
                    'total_kuantitas' => $trx->total_kuantitas,
                    'total_nilai' => $trx->total_nilai,
                ]
            ]);
        }

        return redirect()->route('transaksi.faktur-pembelian', ['q' => $trx->no_transaksi]);
    }

    /**
     * Cetak Lembar Faktur / Surat Penerimaan Barang.
     */
    public function cetakFakturPembelian($id)
    {
        $trx = GdTerimaBeliM::with(['rekanan', 'po', 'details.barang', 'details.satuan'])
            ->findOrFail($id);

        return view('transaksi.cetak_faktur', compact('trx'));
    }

    /**
     * Hapus / Batalkan Transaksi Penerimaan Pembelian.
     */
    public function destroyFakturPembelian(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $trx = GdTerimaBeliM::findOrFail($id);
            $noTrans = $trx->no_transaksi;

            // Hapus detail terlebih dahulu untuk menjaga constraint FK
            GdTerimaBeliD::where('id_transaksi', $id)->delete();

            // Hapus header
            $trx->delete();

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Transaksi [{$noTrans}] berhasil dihapus dari Oracle Database.",
                ]);
            }

            return redirect()->route('transaksi.faktur-pembelian')
                ->with('success', "Transaksi [{$noTrans}] berhasil dibatalkan dan dihapus.");

        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error("Gagal hapus faktur pembelian: " . $e->getMessage());

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal menghapus transaksi: ' . $e->getMessage(),
                ], 500);
            }

            return back()->with('error', 'Gagal menghapus transaksi: ' . $e->getMessage());
        }
    }

    /**
     * Tampilan Halaman Barang Keluar.
     */
    public function barangKeluar()
    {
        $items = MItem::with('satuan')->orderBy('kode_barang')->get();
        $satuans = MSatuan::orderBy('kode_satuan')->get();
        $noTransaksi = 'BK-' . Carbon::now()->format('Ymd') . '-001';

        return view('transaksi.barang_keluar', compact('items', 'satuans', 'noTransaksi'));
    }
}

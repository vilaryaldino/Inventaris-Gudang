<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\GdTerimaBeliM;
use App\Models\GdTerimaBeliD;
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
        $query = GdTerimaBeliM::with(['rekanan', 'details.barang', 'details.satuan']);

        if ($request->filled('q')) {
            $q = trim($request->q);
            $query->where(function ($sub) use ($q) {
                $sub->where('no_transaksi', 'LIKE', "%{$q}%")
                    ->orWhere('no_sj', 'LIKE', "%{$q}%")
                    ->orWhere('keterangan', 'LIKE', "%{$q}%")
                    ->orWhereHas('rekanan', function ($r) use ($q) {
                        $r->where('nama_rekanan', 'LIKE', "%{$q}%")
                          ->orWhere('kode_rekanan', 'LIKE', "%{$q}%");
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

        // 4. Data Master untuk Formulir Input
        $rekanans = MRekanan::orderBy('nama_rekanan')->get();
        $items = MItem::with(['satuan.satuanDasar'])->orderBy('kode_barang')->get();
        $satuans = MSatuan::orderBy('kode_satuan')->get();

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
            'noTransaksiPreview',
            'tglTransaksi',
            'tglInsert',
            'activeTab'
        ));
    }

    /**
     * Simpan Transaksi Penerimaan Pembelian Baru.
     * Menggunakan Sequence Oracle SEQ_GD_TERIMA_M untuk Header dan SEQ_GD_TERIMA_D untuk Detail.
     * Dibungkus dalam DB Transaction untuk menjamin integritas data (ACID).
     */
    public function storeFakturPembelian(Request $request)
    {
        // 1. Validasi Input Server-Side
        $validated = $request->validate([
            'no_transaksi' => 'nullable|string|max:50',
            'tgl_transaksi' => 'required',
            'id_rekanan' => 'required|integer|exists:m_rekanan,id',
            'no_sj' => 'nullable|string|max:50',
            'tgl_sj' => 'nullable',
            'keterangan' => 'nullable|string|max:255',
            'items' => 'required|array|min:1',
            'items.*.id_barang' => 'required|integer|exists:m_item,id_barang',
            'items.*.id_satuan' => 'required|integer|exists:m_satuan,id',
            'items.*.jumlah' => 'required|numeric|min:0.0001',
            'items.*.harga_satuan' => 'nullable|numeric|min:0',
        ], [
            'id_rekanan.required' => 'Pemasok / Rekanan wajib dipilih.',
            'id_rekanan.exists' => 'Rekanan yang dipilih tidak ditemukan di master data.',
            'items.required' => 'Daftar barang faktur tidak boleh kosong.',
            'items.min' => 'Faktur harus berisi minimal 1 barang.',
            'items.*.id_barang.required' => 'Barang pada setiap baris wajib dipilih.',
            'items.*.id_barang.exists' => 'Barang yang dipilih tidak valid di database.',
            'items.*.id_satuan.required' => 'Satuan barang wajib dipilih.',
            'items.*.jumlah.required' => 'Jumlah barang wajib diisi dan lebih besar dari 0.',
        ]);

        try {
            DB::beginTransaction();

            // 2. Ambil Sequence ID untuk Header dari Oracle SEQ_GD_TERIMA_M
            $seqHeader = DB::selectOne("SELECT SEQ_GD_TERIMA_M.NEXTVAL as val FROM DUAL");
            $idTransaksi = (int) $seqHeader->val;

            // 3. Format Tanggal
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

            // 4. Nomor Transaksi Otomatis
            $noCounter = str_pad($idTransaksi, 5, '0', STR_PAD_LEFT);
            $noTransaksi = $request->filled('no_transaksi') && $request->no_transaksi !== '-'
                ? trim($request->no_transaksi)
                : 'TB' . Carbon::now()->format('ym') . $noCounter;

            // Pastikan tidak ada duplikasi nomor transaksi
            $cekNo = DB::table('gd_terima_beli_m')->where('no_transaksi', $noTransaksi)->exists();
            if ($cekNo) {
                $noTransaksi = 'TB' . Carbon::now()->format('ym') . $noCounter . '-' . $idTransaksi;
            }

            $nowStr = Carbon::now()->format('Y-m-d H:i:s');
            $operator = auth()->check() ? auth()->user()->name : 'SYSTEM';

            // 5. Simpan Header (gd_terima_beli_m)
            DB::table('gd_terima_beli_m')->insert([
                'id_transaksi' => $idTransaksi,
                'no_transaksi' => $noTransaksi,
                'no_transaksi_kode' => 'TB',
                'no_transaksi_counter' => $noCounter,
                'jns_transaksi' => '03',
                'tgl_transaksi' => $tglTransaksi,
                'no_sj' => $request->filled('no_sj') ? trim($request->no_sj) : '-',
                'tgl_sj' => $tglSj,
                'id_rekanan' => $request->id_rekanan,
                'id_po' => null,
                'keterangan' => $request->keterangan,
                'tgl_insert' => $nowStr,
                'opr_insert' => $operator,
            ]);

            // 6. Simpan Detail Barang (gd_terima_beli_d)
            $noUrut = 1;
            foreach ($request->items as $itemData) {
                // Ambil Sequence ID untuk Detail dari Oracle SEQ_GD_TERIMA_D
                $seqDetail = DB::selectOne("SELECT SEQ_GD_TERIMA_D.NEXTVAL as val FROM DUAL");
                $idDetail = (int) $seqDetail->val;

                $jumlah = (float) $itemData['jumlah'];
                $hargaSatuan = isset($itemData['harga_satuan']) ? (float) $itemData['harga_satuan'] : 0;
                $totalNilai = $jumlah * $hargaSatuan;

                DB::table('gd_terima_beli_d')->insert([
                    'id_detail' => $idDetail,
                    'id_transaksi' => $idTransaksi,
                    'no_urut' => $noUrut,
                    'id_barang' => (int) $itemData['id_barang'],
                    'id_satuan' => (int) $itemData['id_satuan'],
                    'jumlah' => $jumlah,
                    'total' => $totalNilai,
                    'tgl_dibutuhkan' => null,
                    'is_project' => 'N',
                    'id_project' => null,
                    'id_po' => null,
                    'id_po_detail' => null,
                    'jumlah2' => null,
                    'id_satuan2' => null,
                    'id_pesan' => null,
                    'is_stok' => 'Y',
                    'lokasi_gdg' => null,
                ]);

                $noUrut++;
            }

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => "Faktur Penerimaan [{$noTransaksi}] berhasil disimpan ke Oracle Database! (ID Transaksi: {$idTransaksi})",
                    'id_transaksi' => $idTransaksi,
                    'no_transaksi' => $noTransaksi,
                ]);
            }

            return redirect()->route('transaksi.faktur-pembelian')
                ->with('success', "Faktur Penerimaan [{$noTransaksi}] berhasil disimpan dengan ID Transaksi: {$idTransaksi}.");

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
        $trx = GdTerimaBeliM::with(['rekanan', 'details.barang', 'details.satuan'])
            ->findOrFail($id);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'data' => [
                    'id_transaksi' => $trx->id_transaksi,
                    'no_transaksi' => $trx->no_transaksi,
                    'tgl_transaksi' => $trx->tgl_transaksi ? Carbon::parse($trx->tgl_transaksi)->format('d/m/Y') : '-',
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
        $trx = GdTerimaBeliM::with(['rekanan', 'details.barang', 'details.satuan'])
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

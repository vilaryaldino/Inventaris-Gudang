<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdTerimaBeliD extends Model
{
    /**
     * Nama tabel Oracle sesuai skema aktual.
     */
    protected $table = 'gd_terima_beli_d';

    /**
     * Primary Key tabel detail.
     */
    protected $primaryKey = 'id_detail';

    /**
     * Sequence Oracle untuk id_detail.
     */
    public $sequence = 'SEQ_GD_TERIMA_D';

    /**
     * Tabel tidak menggunakan timestamp Laravel standard.
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'id_detail',
        'id_transaksi',
        'no_urut',
        'id_barang',
        'id_satuan',
        'jumlah',
        'total',
        'tgl_dibutuhkan',
        'is_project',
        'id_project',
        'id_po',
        'id_po_detail',
        'jumlah2',
        'id_satuan2',
        'id_pesan',
        'is_stok',
        'lokasi_gdg',
    ];

    /**
     * Format casting tipe data kolom.
     */
    protected $casts = [
        'id_detail' => 'integer',
        'id_transaksi' => 'integer',
        'no_urut' => 'integer',
        'id_barang' => 'integer',
        'id_satuan' => 'integer',
        'jumlah' => 'decimal:2',
        'total' => 'decimal:2',
        'tgl_dibutuhkan' => 'date',
    ];

    /**
     * Relasi ke Header Penerimaan Pembelian (gd_terima_beli_m).
     */
    public function header(): BelongsTo
    {
        return $this->belongsTo(GdTerimaBeliM::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi ke Master Barang / Item (m_item).
     */
    public function barang(): BelongsTo
    {
        return $this->belongsTo(MItem::class, 'id_barang', 'id_barang');
    }

    /**
     * Relasi ke Master Satuan (m_satuan).
     */
    public function satuan(): BelongsTo
    {
        return $this->belongsTo(MSatuan::class, 'id_satuan', 'id');
    }
}

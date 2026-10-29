<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PmbPurchorderD extends Model
{
    /**
     * Nama tabel Oracle simulasi Purchase Order Detail.
     */
    protected $table = 'pmb_purchorder_d';

    /**
     * Primary Key tabel detail PO.
     */
    protected $primaryKey = 'id_detail';

    /**
     * Non-incrementing karena ID detail di-generate secara kustom.
     */
    public $incrementing = false;
    protected $keyType = 'int';

    /**
     * Tabel PO tidak menggunakan timestamps standar Laravel.
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
        'harga',
        'disc_persen',
        'disc_rp',
        'biaya_persen',
        'biaya_rp',
        'total_bruto',
        'total',
        'jumlah2',
        'id_satuan2',
        'id_pesan',
        'id_pesan_d',
        'qty_bpb',
        'tgl_dibutuhkan',
        'is_project',
        'id_project',
        'id_struktur',
        'qty_satuan',
        'keterangan',
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
        'harga' => 'decimal:2',
        'total' => 'decimal:2',
        'tgl_dibutuhkan' => 'date',
    ];

    /**
     * Relasi ke Header PO (pmb_purchorder_m).
     */
    public function header(): BelongsTo
    {
        return $this->belongsTo(PmbPurchorderM::class, 'id_transaksi', 'id_transaksi');
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


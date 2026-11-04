<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdBonKeluarD extends Model
{
    /**
     * Nama tabel Oracle sesuai skema aktual.
     */
    protected $table = 'gd_bon_keluar_d';

    /**
     * Primary Key tabel detail.
     */
    protected $primaryKey = 'id_detail';

    /**
     * Sequence Oracle untuk id_detail.
     */
    public $sequence = 'SEQ_GD_BON_KELUAR_D';

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
        'jumlah',
        'id_satuan',
        'is_project',
        'id_project',
        'id_struktur',
        'asal_stok',
        'heat_no',
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
        'id_project' => 'integer',
        'id_struktur' => 'integer',
        'jumlah' => 'decimal:2',
    ];

    /**
     * Relasi ke Header Bukti Barang Keluar (gd_bon_keluar_m).
     */
    public function header(): BelongsTo
    {
        return $this->belongsTo(GdBonKeluarM::class, 'id_transaksi', 'id_transaksi');
    }

    /**
     * Relasi ke Master Item Barang (m_item).
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

    /**
     * Relasi ke Master Project IKI per baris item (m_project_iki).
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(MProjectIki::class, 'id_project', 'id_project');
    }
}


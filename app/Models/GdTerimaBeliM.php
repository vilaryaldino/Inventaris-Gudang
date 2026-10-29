<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdTerimaBeliM extends Model
{
    /**
     * Nama tabel Oracle sesuai skema aktual.
     */
    protected $table = 'gd_terima_beli_m';

    /**
     * Primary Key tabel header.
     */
    protected $primaryKey = 'id_transaksi';

    /**
     * Sequence Oracle untuk id_transaksi.
     */
    public $sequence = 'SEQ_GD_TERIMA_M';

    /**
     * Tabel tidak menggunakan timestamp Laravel (created_at / updated_at),
     * melainkan tgl_insert dan opr_insert.
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'id_transaksi',
        'no_transaksi',
        'no_transaksi_kode',
        'no_transaksi_counter',
        'jns_transaksi',
        'tgl_transaksi',
        'no_sj',
        'tgl_sj',
        'id_rekanan',
        'id_po',
        'no_po',
        'keterangan',
        'tgl_insert',
        'opr_insert',
    ];

    /**
     * Format casting tipe data kolom.
     */
    protected $casts = [
        'id_transaksi' => 'integer',
        'id_rekanan' => 'integer',
        'id_po' => 'integer',
        'tgl_transaksi' => 'datetime',
        'tgl_sj' => 'datetime',
        'tgl_insert' => 'datetime',
    ];

    /**
     * Relasi ke Detail Penerimaan Barang (gd_terima_beli_d).
     */
    public function details(): HasMany
    {
        return $this->hasMany(GdTerimaBeliD::class, 'id_transaksi', 'id_transaksi')
                    ->orderBy('no_urut', 'asc');
    }

    /**
     * Relasi ke Master Rekanan / Vendor (m_rekanan).
     */
    public function rekanan(): BelongsTo
    {
        return $this->belongsTo(MRekanan::class, 'id_rekanan', 'id');
    }

    /**
     * Relasi ke Purchase Order Header (pmb_purchorder_m).
     */
    public function po(): BelongsTo
    {
        return $this->belongsTo(PmbPurchorderM::class, 'id_po', 'id_transaksi');
    }

    /**
     * Accessor untuk total item kuantitas dalam transaksi.
     */
    public function getTotalKuantitasAttribute(): float
    {
        return (float) $this->details->sum('jumlah');
    }

    /**
     * Accessor untuk total nominal transaksi.
     */
    public function getTotalNilaiAttribute(): float
    {
        return (float) $this->details->sum('total');
    }
}

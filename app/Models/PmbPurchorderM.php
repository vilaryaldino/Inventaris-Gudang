<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PmbPurchorderM extends Model
{
    /**
     * Nama tabel Oracle simulasi Purchase Order Header.
     */
    protected $table = 'pmb_purchorder_m';

    /**
     * Primary Key tabel header PO.
     */
    protected $primaryKey = 'id_transaksi';

    /**
     * Non-incrementing karena ID transaksi PO di-generate secara kustom/sequence khusus.
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
        'id_transaksi',
        'no_transaksi',
        'no_transaksi_kode',
        'no_transaksi_counter',
        'jns_transaksi',
        'id_rekanan',
        'tgl_transaksi',
        'status',
        'keterangan',
        'opr_insert',
        'tgl_insert',
    ];

    /**
     * Format casting tipe data kolom.
     */
    protected $casts = [
        'id_transaksi' => 'integer',
        'id_rekanan' => 'integer',
        'tgl_transaksi' => 'datetime',
        'tgl_insert' => 'datetime',
    ];

    /**
     * Relasi ke Detail PO (pmb_purchorder_d).
     */
    public function details(): HasMany
    {
        return $this->hasMany(PmbPurchorderD::class, 'id_transaksi', 'id_transaksi')
                    ->orderBy('no_urut', 'asc');
    }

    /**
     * Relasi ke Master Rekanan / Pemasok (m_rekanan).
     */
    public function rekanan(): BelongsTo
    {
        return $this->belongsTo(MRekanan::class, 'id_rekanan', 'id');
    }

    /**
     * Relasi ke Histori Penerimaan Gudang (gd_terima_beli_m).
     */
    public function penerimaan(): HasMany
    {
        return $this->hasMany(GdTerimaBeliM::class, 'id_po', 'id_transaksi');
    }

    /**
     * Accessor total kuantitas barang dalam PO.
     */
    public function getTotalQtyAttribute(): float
    {
        return (float) $this->details->sum('jumlah');
    }

    /**
     * Accessor total nilai nominal PO.
     */
    public function getTotalNilaiAttribute(): float
    {
        return (float) $this->details->sum('total');
    }
}


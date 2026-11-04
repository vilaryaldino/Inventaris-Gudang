<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GdBonKeluarM extends Model
{
    /**
     * Nama tabel Oracle sesuai skema aktual.
     */
    protected $table = 'gd_bon_keluar_m';

    /**
     * Primary Key tabel header.
     */
    protected $primaryKey = 'id_transaksi';

    /**
     * Sequence Oracle untuk id_transaksi.
     */
    public $sequence = 'SEQ_GD_BON_KELUAR_M';

    /**
     * Tabel tidak menggunakan timestamp default Laravel.
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
        'kode_transaksi',
        'tgl_transaksi',
        'id_project_pakai',
        'subkon_pakai',
        'id_divisi_group',
        'id_gudang',
        'no_cutting',
        'keterangan',
        'status',
        'opr_insert',
        'tgl_insert',
    ];

    /**
     * Format casting tipe data kolom.
     */
    protected $casts = [
        'id_transaksi' => 'integer',
        'id_project_pakai' => 'integer',
        'id_divisi_group' => 'integer',
        'id_gudang' => 'integer',
        'tgl_transaksi' => 'date',
        'tgl_insert' => 'datetime',
    ];

    /**
     * Relasi ke Detail Barang Keluar (gd_bon_keluar_d).
     */
    public function details(): HasMany
    {
        return $this->hasMany(GdBonKeluarD::class, 'id_transaksi', 'id_transaksi')
                    ->orderBy('no_urut', 'asc');
    }

    /**
     * Relasi ke Master Project IKI (m_project_iki).
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(MProjectIki::class, 'id_project_pakai', 'id_project');
    }

    /**
     * Accessor total kuantitas barang yang dikeluarkan.
     */
    public function getTotalKuantitasAttribute(): float
    {
        return (float) $this->details->sum('jumlah');
    }

    /**
     * Accessor total item barang unik.
     */
    public function getTotalItemsAttribute(): int
    {
        return $this->details->count();
    }
}


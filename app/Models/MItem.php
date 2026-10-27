<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MItem extends Model
{
    protected $table = 'm_item';

    /**
     * Primary Key tabel m_item menggunakan id_barang
     * agar berelasi langsung dengan gd_terima_beli_d.id_barang.
     */
    protected $primaryKey = 'id_barang';

    public $sequence = 'm_item_id_seq';

    protected $fillable = [
        'id_barang',
        'kode_barang',
        'nama_barang',
        'id_satuan',
        'harga_satuan',
    ];

    protected $casts = [
        'id_barang' => 'integer',
        'harga_satuan' => 'decimal:2',
    ];

    /**
     * Helper accessor untuk backward compatibility jika properti ->id dipanggil.
     */
    public function getIdAttribute()
    {
        return $this->attributes['id_barang'] ?? null;
    }

    /**
     * Relasi ke Master Satuan.
     */
    public function satuan(): BelongsTo
    {
        return $this->belongsTo(MSatuan::class, 'id_satuan', 'id');
    }

    /**
     * Helper accessor untuk mengakses satuan dasar barang melalui relasi satuan.
     */
    public function getSatuanDasarAttribute()
    {
        return $this->satuan?->satuanDasar;
    }
}

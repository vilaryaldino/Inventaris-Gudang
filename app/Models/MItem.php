<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MItem extends Model
{
    protected $table = 'm_item';

    protected $primaryKey = 'id';

    public $sequence = 'm_item_id_seq';

    protected $fillable = [
        'kode_barang',
        'nama_barang',
        'id_satuan',
        'harga_satuan',
    ];

    protected $casts = [
        'harga_satuan' => 'decimal:2',
    ];

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

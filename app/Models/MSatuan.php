<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MSatuan extends Model
{
    protected $table = 'm_satuan';

    protected $primaryKey = 'id';

    public $sequence = 'm_satuan_id_seq';

    protected $fillable = [
        'id_satuan_dasar',
        'kode_satuan',
        'nama_satuan',
        'konversi',
    ];

    protected $casts = [
        'konversi' => 'decimal:4',
    ];

    /**
     * Relasi balik ke Satuan Dasar (Induk).
     */
    public function satuanDasar(): BelongsTo
    {
        return $this->belongsTo(MSatuanDasar::class, 'id_satuan_dasar', 'id');
    }

    /**
     * Relasi ke m_item (Satu Satuan digunakan oleh banyak Barang).
     */
    public function item(): HasMany
    {
        return $this->hasMany(MItem::class, 'id_satuan', 'id');
    }
}

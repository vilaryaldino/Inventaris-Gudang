<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MSatuanDasar extends Model
{
    /**
     * Nama tabel eksplisit (non-plural convention).
     */
    protected $table = 'm_satuan_dasar';

    /**
     * Primary key tabel.
     */
    protected $primaryKey = 'id';

    /**
     * Nama sequence Oracle untuk primary key.
     */
    public $sequence = 'm_satuan_dasar_id_seq';

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'kode_satuan',
        'nama_satuan',
    ];

    /**
     * Relasi ke m_satuan (Satu Satuan Dasar memiliki banyak Satuan Konversi).
     */
    public function satuan(): HasMany
    {
        return $this->hasMany(MSatuan::class, 'id_satuan_dasar', 'id');
    }
}

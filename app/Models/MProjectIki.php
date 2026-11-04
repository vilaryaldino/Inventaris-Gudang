<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MProjectIki extends Model
{
    /**
     * Nama tabel Oracle sesuai skema aktual.
     */
    protected $table = 'm_project_iki';

    /**
     * Primary Key tabel master project.
     */
    protected $primaryKey = 'id_project';

    /**
     * Tidak auto-incrementing default jika diatur manual dari Oracle.
     */
    public $incrementing = true;

    /**
     * Timestamp tabel Oracle.
     */
    public $timestamps = false;

    /**
     * Kolom yang dapat diisi melalui mass assignment.
     */
    protected $fillable = [
        'id_project',
        'kd_project',
        'nm_project',
        'tgl_project',
    ];

    /**
     * Casting tipe data kolom.
     */
    protected $casts = [
        'id_project' => 'integer',
        'tgl_project' => 'date',
    ];

    /**
     * Relasi ke Header Bukti Barang Keluar.
     */
    public function bonKeluarHeaders(): HasMany
    {
        return $this->hasMany(GdBonKeluarM::class, 'id_project_pakai', 'id_project');
    }

    /**
     * Relasi ke Detail Bukti Barang Keluar.
     */
    public function bonKeluarDetails(): HasMany
    {
        return $this->hasMany(GdBonKeluarD::class, 'id_project', 'id_project');
    }
}


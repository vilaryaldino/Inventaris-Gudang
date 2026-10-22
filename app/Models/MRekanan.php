<?php

namespace App\Models;

use Yajra\Oci8\Eloquent\OracleEloquent as Model;

class MRekanan extends Model
{
    protected $table = 'm_rekanan';

    protected $primaryKey = 'id';

    public $sequence = 'm_rekanan_id_seq';

    protected $fillable = [
        'kode_rekanan',
        'nama_rekanan',
        'alamat',
        'no_telp',
    ];
}

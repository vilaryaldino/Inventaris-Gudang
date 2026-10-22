<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MSatuanDasar;
use App\Models\MSatuan;
use App\Models\MRekanan;
use App\Models\MItem;

class MasterDataSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Satuan Dasar
        $sdPcs = MSatuanDasar::firstOrCreate(['kode_satuan' => 'PCS'], ['nama_satuan' => 'Pieces']);
        $sdKg  = MSatuanDasar::firstOrCreate(['kode_satuan' => 'KG'],  ['nama_satuan' => 'Kilogram']);
        $sdMtr = MSatuanDasar::firstOrCreate(['kode_satuan' => 'MTR'], ['nama_satuan' => 'Meter']);
        $sdM3  = MSatuanDasar::firstOrCreate(['kode_satuan' => 'M3'],  ['nama_satuan' => 'Meter Kubik']);
        $sdZak = MSatuanDasar::firstOrCreate(['kode_satuan' => 'ZAK'], ['nama_satuan' => 'Zak']);

        // 2. Satuan Konversi
        $sPcs = MSatuan::firstOrCreate(['kode_satuan' => 'Pcs'], [
            'id_satuan_dasar' => $sdPcs->id,
            'nama_satuan' => 'Pieces',
            'konversi' => 1
        ]);
        $sZak = MSatuan::firstOrCreate(['kode_satuan' => 'Zak'], [
            'id_satuan_dasar' => $sdZak->id,
            'nama_satuan' => 'Zak Semen 50kg',
            'konversi' => 1
        ]);
        $sM3 = MSatuan::firstOrCreate(['kode_satuan' => 'M3'], [
            'id_satuan_dasar' => $sdM3->id,
            'nama_satuan' => 'Meter Kubik',
            'konversi' => 1
        ]);
        $sKg = MSatuan::firstOrCreate(['kode_satuan' => 'Kg'], [
            'id_satuan_dasar' => $sdKg->id,
            'nama_satuan' => 'Kilogram',
            'konversi' => 1
        ]);
        $sBtg = MSatuan::firstOrCreate(['kode_satuan' => 'Btg'], [
            'id_satuan_dasar' => $sdMtr->id,
            'nama_satuan' => 'Batang (6 Meter)',
            'konversi' => 6
        ]);

        // 3. Rekanan / Supplier
        MRekanan::firstOrCreate(['kode_rekanan' => 'R12345'], [
            'nama_rekanan' => 'CV. Sumber Rejeki',
            'alamat' => 'Jl. Daan Mogot Km 12, Cengkareng, Jakarta Barat',
            'no_telp' => '021-54398112'
        ]);
        MRekanan::firstOrCreate(['kode_rekanan' => 'SPL-002'], [
            'nama_rekanan' => 'PT. Megah Baja Nusantara',
            'alamat' => 'Kawasan Industri Jababeka Blok C-4, Cikarang',
            'no_telp' => '021-89834110'
        ]);
        MRekanan::firstOrCreate(['kode_rekanan' => 'SPL-003'], [
            'nama_rekanan' => 'UD. Sentosa Pasir & Semen',
            'alamat' => 'Jl. Raya Bogor KM 31, Depok',
            'no_telp' => '081298765432'
        ]);

        // 4. Item / Barang Gudang (Sesuai contoh user)
        MItem::firstOrCreate(['kode_barang' => 'BRG001'], [
            'nama_barang' => 'Besi Hollow 4x4',
            'id_satuan' => $sPcs->id,
            'harga_satuan' => 85000
        ]);
        MItem::firstOrCreate(['kode_barang' => 'BRG002'], [
            'nama_barang' => 'Semen Tiga Roda',
            'id_satuan' => $sZak->id,
            'harga_satuan' => 58000
        ]);
        MItem::firstOrCreate(['kode_barang' => 'BRG003'], [
            'nama_barang' => 'Pasir Pasang',
            'id_satuan' => $sM3->id,
            'harga_satuan' => 150000
        ]);
        MItem::firstOrCreate(['kode_barang' => 'BRG004'], [
            'nama_barang' => 'Batu Split',
            'id_satuan' => $sM3->id,
            'harga_satuan' => 160000
        ]);
        MItem::firstOrCreate(['kode_barang' => 'BRG005'], [
            'nama_barang' => 'Paku 7 cm',
            'id_satuan' => $sKg->id,
            'harga_satuan' => 22000
        ]);
    }
}

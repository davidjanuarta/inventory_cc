<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StokBarang extends Model
{
    use HasFactory;

    protected $table = 'stock_barang';

    // Tambahkan atribut yang diizinkan untuk mass assignment
    protected $fillable = [
        'nama',
        'jenis',
        'merk',
        'ukuran',
        'stock',
        'satuan',
        'lokasi',
        'gambar'  // Pastikan nama kolom ini sesuai dengan kolom di database
    ];

    public function barangKeluars()
    {
        return $this->hasMany(BarangKeluar::class, 'stock_barang_id');
    }

    public function barangMasuks()
    {
        return $this->hasMany(BarangMasuk::class, 'stock_barang_id');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangKeluar extends Model
{
    use HasFactory;

    protected $table = 'barang_keluar';

    // Tambahkan atribut yang diizinkan untuk mass assignment
    protected $fillable = [
        'stock_barang_id',
        'tgl',
        'jumlah',
        'penerima',
        'keterangan',
    ];

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class, 'stock_barang_id');
    }
}

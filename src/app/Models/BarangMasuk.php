<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BarangMasuk extends Model
{
    use HasFactory;

    protected $table = 'barang_masuk';

    protected $fillable = [
        'stock_barang_id',
        'jumlah',
        'tgl',
        'keterangan',
    ];

    public function stokBarang()
    {
        return $this->belongsTo(StokBarang::class, 'stock_barang_id');
    }
}

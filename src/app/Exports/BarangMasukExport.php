<?php

namespace App\Exports;

use App\Models\BarangMasuk;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangMasukExport implements FromView, WithStyles, WithHeadings
{
    public function view(): View
    {
        return view('transaksidata.barangmasuk.exportbm_excel', [
            'barangmasuk' => BarangMasuk::all()
        ]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]],
        ];
    }


    public function headings(): array
    {
        return [
            'No',
            'Tanggal Masuk',
            'Nama barang',
            'Jenis',
            'Merk',
            'Ukuran',
            'Jumlah Masuk',
            'Keterangan',
        ];
    }
}

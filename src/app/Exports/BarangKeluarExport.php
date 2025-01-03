<?php

namespace App\Exports;

use App\Models\BarangKeluar;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class BarangKeluarExport implements FromView, WithStyles, WithHeadings
{
    public function view(): View
    {
        return view('transaksidata.barangkeluar.exportbk_excel', [
            'barangkeluar' => BarangKeluar::all()
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
            'Tanggal Keluar',
            'Nama barang',
            'Jenis',
            'Merk',
            'Ukuran',
            'Jumlah Keluar',
            'Penerima',
            'Keterangan',
        ];
    }
}

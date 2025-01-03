<?php

namespace App\Exports;

use App\Models\StokBarang;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockExport implements FromView, WithStyles, WithHeadings
{
    public function view(): View
    {
        return view('stock.export_excel', [
            'stock' => StokBarang::all()
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
            'Gambar',
            'Nama',
            'Jenis',
            'Merk',
            'Ukuran',
            'Stock',
            'Satuan',
            'Lokasi',
        ];
    }
}

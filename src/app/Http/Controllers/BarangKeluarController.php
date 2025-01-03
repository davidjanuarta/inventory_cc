<?php

namespace App\Http\Controllers;

use App\Exports\BarangKeluarExport;
use App\Models\BarangKeluar;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BarangKeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $pageTitle = 'Barang Keluar';

        confirmDelete();

        // Ambil data barang keluar
        $barangkeluars = BarangKeluar::all();

        // Ambil data stok barang
        $stock = StokBarang::all()->keyBy('id'); // Mengubah stok barang menjadi array dengan ID sebagai kunci

        return view('transaksidata.barangkeluar.index', compact('barangkeluars', 'stock', 'pageTitle'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            'stock_barang_id' => 'required|exists:stock_barang,id', // Pastikan stok barang ada
            'jumlah' => 'required|integer|min:1',
            'tgl' => 'required|date',
            'penerima' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Ambil stok barang berdasarkan ID
        $stokBarang = StokBarang::find($request->stock_barang_id);

        if (!$stokBarang) {
            return redirect()->back()->with('error', 'Stok barang tidak ditemukan.');
        }

        // Pastikan stok barang cukup untuk dikurangi
        if ($stokBarang->stock < $request->jumlah) {
            return redirect()->back()->with('error', 'Jumlah barang keluar melebihi stok yang tersedia.');
        }

        // Simpan data barang keluar
        BarangKeluar::create([
            'stock_barang_id' => $request->stock_barang_id,
            'jumlah' => $request->jumlah,
            'tgl' => $request->tgl,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
        ]);

        // Kurangi stok barang
        $stokBarang->stock -= $request->jumlah;
        $stokBarang->save();

        Alert::success('Added Successfully', 'Sukses Menambahkan Barang Keluar.');

        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil ditambahkan.');
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id) {}

    // Method update untuk memperbarui data barang keluar
    public function update(Request $request, BarangKeluar $barangkeluar)
    {
        // Validasi data yang diterima dari form
        $request->validate([
            'tgl' => 'required|date',
            'jumlah' => 'required|numeric',
            'penerima' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:255',
        ]);

        // Temukan stok barang yang terkait dengan barang keluar
        $stokBarang = StokBarang::find($barangkeluar->stock_barang_id);

        if (!$stokBarang) {
            return redirect()->back()->with('error', 'Stok barang tidak ditemukan.');
        }

        // Hitung perbedaan jumlah barang
        $difference = $request->jumlah - $barangkeluar->jumlah;

        // Update data barang keluar
        $barangkeluar->update([
            'tgl' => $request->tgl,
            'jumlah' => $request->jumlah,
            'penerima' => $request->penerima,
            'keterangan' => $request->keterangan,
        ]);

        // Update stok barang berdasarkan perbedaan jumlah
        $stokBarang->stock -= $difference;
        $stokBarang->save();

        Alert::success('Success', 'Barang keluar berhasil diperbarui.');
        return redirect()->route('barangkeluar.index')->with('success', 'Barang keluar berhasil diperbarui dan stok telah diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan barang keluar berdasarkan ID
        $barangkeluar = BarangKeluar::findOrFail($id);

        // Temukan stok barang yang terkait dengan barang keluar
        $stokBarang = StokBarang::find($barangkeluar->stock_barang_id);

        if ($stokBarang) {
            // Kembalikan jumlah barang ke stok
            $stokBarang->stock += $barangkeluar->jumlah;
            $stokBarang->save();
        }

        // Hapus barang keluar dari database
        $barangkeluar->delete();

        // Tampilkan pesan sukses dengan SweetAlert
        Alert::success('Deleted Successfully', 'Item Deleted Successfully.');

        // Redirect ke halaman barang keluar
        return redirect()->route('barangkeluar.index')->with('success', 'Barang berhasil dihapus dan stok telah diperbarui!');
    }

    public function exportExcelbk()
    {
        return Excel::download(new BarangKeluarExport, 'Barang Keluar.xlsx');
    }
    public function exportPdfbk()
    {
        $barangkeluar = BarangKeluar::all();

        $pdf = PDF::loadView('transaksidata.barangkeluar.exportbk_pdf', compact('barangkeluar'));

        return $pdf->download('barang keluar.pdf');
    }
}

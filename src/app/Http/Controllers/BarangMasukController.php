<?php

namespace App\Http\Controllers;

use App\Exports\BarangMasukExport;
use App\Models\BarangMasuk;
use App\Models\StokBarang;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use PDF;

class BarangMasukController extends Controller
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
        $pageTitle = 'Barang Masuk';

        confirmDelete();

        $barangmasuks = BarangMasuk::with('stokBarang')->get();
        $stock = StokBarang::all(); // Untuk dropdown
        return view('transaksidata.barangmasuk.index', compact('barangmasuks', 'stock'));
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
            'stock_barang_id' => 'required|exists:stock_barang,id',
            'jumlah' => 'required|integer|min:1',
            'tgl' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Buat data barang masuk
        $barangMasuk = new BarangMasuk();
        $barangMasuk->stock_barang_id = $request->input('stock_barang_id');
        $barangMasuk->jumlah = $request->input('jumlah');
        $barangMasuk->tgl = $request->input('tgl');
        $barangMasuk->keterangan = $request->input('keterangan');
        $barangMasuk->save();

        // Update stok barang
        $stokBarang = StokBarang::find($request->input('stock_barang_id'));
        $stokBarang->stock += $request->input('jumlah');
        $stokBarang->save();

        Alert::success('Added Successfully', 'Sukses Menambahkan Barang Masuk.');
        return redirect()->route('barangmasuk.index')->with('success', 'Barang masuk berhasil ditambahkan dan stok telah diperbarui.');
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'jumlah' => 'required|integer|min:1',
            'tgl' => 'required|date',
            'keterangan' => 'nullable|string',
        ]);

        // Temukan barang masuk yang akan diperbarui
        $barangMasuk = BarangMasuk::findOrFail($id);

        // Ambil stok barang sebelum perubahan
        $stokBarang = StokBarang::find($barangMasuk->stock_barang_id);

        // Hitung perbedaan jumlah barang
        $difference = $request->jumlah - $barangMasuk->jumlah;

        // Update jumlah barang masuk
        $barangMasuk->update([
            'jumlah' => $request->jumlah,
            'tgl' => $request->tgl,
            'keterangan' => $request->keterangan,
        ]);

        // Update stok barang berdasarkan perbedaan jumlah
        $stokBarang->stock += $difference;
        $stokBarang->save();

        Alert::success('Updated Successfully', 'Sukses Memperbarui Barang Masuk.');
        return redirect()->route('barangmasuk.index')->with('success', 'Barang Masuk berhasil diperbarui dan stok telah diperbarui.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Temukan barang keluar berdasarkan ID
        $barangmasuk = BarangMasuk::findOrFail($id);


        // Temukan stok barang yang terkait dengan barang masuk
        $stokBarang = StokBarang::find($barangmasuk->stock_barang_id);

        if ($stokBarang) {
            // Kurangi jumlah barang dari stok
            $stokBarang->stock -= $barangmasuk->jumlah;
            $stokBarang->save();
        }

        // Hapus barang keluar dari database
        $barangmasuk->delete();

        // Tampilkan pesan sukses dengan SweetAlert
        Alert::success('Deleted Successfully', 'Item Deleted Successfully.');

        // Redirect ke halaman barang keluar
        return redirect()->route('barangmasuk.index')->with('success', 'Barang berhasil dihapus dan stok telah diperbarui!');
    }

    public function exportExcelbm()
    {
        return Excel::download(new BarangMasukExport, 'Barang Masuk.xlsx');
    }
    public function exportPdfbm()
    {
        $barangmasuk = BarangMasuk::all();

        $pdf = PDF::loadView('transaksidata.barangmasuk.exportbm_pdf', compact('barangmasuk'));

        return $pdf->download('barang masuk.pdf');
    }
}

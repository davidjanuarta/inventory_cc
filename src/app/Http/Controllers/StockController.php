<?php

namespace App\Http\Controllers;

use App\Models\StokBarang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockExport;
use PDF;

class StockController extends Controller
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
        $pageTitle = 'Stock Barang';

        confirmDelete();

        $stock = StokBarang::all();


        return view('stock.index', compact('stock', 'pageTitle'));
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
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'stock' => 'required|integer',
            'satuan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Simpan file gambar jika ada
        $imagePath = null;
        if ($request->hasFile('gambar')) {
            $imagePath = $request->file('gambar')->store('images/barang', 'public');
        }

        // Simpan data ke database
        StokBarang::create([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'ukuran' => $request->ukuran,
            'stock' => $request->stock,
            'satuan' => $request->satuan,
            'lokasi' => $request->lokasi,
            'gambar' => $imagePath, // Simpan path gambar
        ]);

        Alert::success('Added Successfully', 'Sukses Menambahkan Barang.');
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stock.index')->with('success', 'Barang berhasil ditambahkan.');
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
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis' => 'required|string|max:255',
            'merk' => 'required|string|max:255',
            'ukuran' => 'required|string|max:255',
            'stock' => 'required|integer',
            'satuan' => 'required|string|max:255',
            'lokasi' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi gambar
        ]);

        // Cari data barang yang akan diupdate
        $stock = StokBarang::findOrFail($id);

        // Simpan file gambar jika ada
        $imagePath = $stock->gambar; // Ambil path gambar lama
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama jika ada
            if ($imagePath && Storage::exists('public/' . $imagePath)) {
                Storage::delete('public/' . $imagePath);
            }
            // Simpan gambar baru
            $imagePath = $request->file('gambar')->store('images/barang', 'public');
        }

        // Update data ke database
        $stock->update([
            'nama' => $request->nama,
            'jenis' => $request->jenis,
            'merk' => $request->merk,
            'ukuran' => $request->ukuran,
            'stock' => $request->stock,
            'satuan' => $request->satuan,
            'lokasi' => $request->lokasi,
            'gambar' => $imagePath, // Simpan path gambar
        ]);

        Alert::success('Updated Successfully', 'Sukses Memperbarui Barang.');
        // Redirect ke halaman index dengan pesan sukses
        return redirect()->route('stock.index')->with('success', 'Barang berhasil diperbarui.');
    }




    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $stock = StokBarang::findOrFail($id);

        // Hapus gambar jika ada
        if ($stock->gambar && file_exists(public_path($stock->gambar))) {
            unlink(public_path($stock->gambar));
        }

        $stock->delete();

        Alert::success('Deleted Successfully', 'Item Deleted


        Successfully.');
        // Redirect dengan SweetAlert
        return redirect()->route('stock.index')->with('success', 'Barang berhasil dihapus!');
    }

    public function exportExcel()
    {
        return Excel::download(new StockExport, 'StockBarang.xlsx');
    }
    public function exportPdf()
    {
        $stock = StokBarang::all();

        $pdf = PDF::loadView('stock.export_pdf', compact('stock'));

        return $pdf->download('stock barang.pdf');
    }
}

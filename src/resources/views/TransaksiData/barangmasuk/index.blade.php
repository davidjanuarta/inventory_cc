@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#barangMasuk').DataTable();
            $(".datatable").on("click", ".btn-delete", function(e) {
                e.preventDefault();

                var form = $(this).closest("form");
                var name = $(this).data("name");

                Swal.fire({
                    title: "Apakah anda yakin menghapus data \n" + name + "?",
                    text: "Data akan dihapus secara permanen",
                    icon: "warning",
                    showCancelButton: true,
                    confirmButtonClass: "bg-primary",
                    confirmButtonText: "Ya, Hapus Sekarang!",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

@section('content')
    @include('layouts.navbar')
    <div id="layoutSidenav">
        @include('layouts.sidebar')
        <div id="layoutSidenav_content">
            <main>
                <div class="container-fluid">
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800">Barang Masuk</h1>
                        <ul class="list-inline mb-0 float-end">
                            <li class="list-inline-item">
                                <a href="{{ route('barangmasuk.exportPdfbm') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                                </a>
                                <a href="{{ route('barangmasuk.exportExcelbm') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download Excel
                                </a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambahBarangModal"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                                    <i class="fas fa-plus fa-sm text-white-50"></i> Tambahkan
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="container-fluid pt-2 px-2">
                        <div class="bg-white justify-content-between rounded shadow p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered table-hover table-striped mb-0 bg-white datatable"
                                    id="barangMasuk" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Masuk</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Merk</th>
                                            <th>Ukuran</th>
                                            <th>Jumlah Masuk</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barangmasuks as $index => $barangmasuk)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $barangmasuk->tgl }}</td>
                                                <td>{{ $barangmasuk->stokBarang->nama ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangmasuk->stokBarang->jenis ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangmasuk->stokBarang->merk ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangmasuk->stokBarang->ukuran ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangmasuk->jumlah }}</td>
                                                <td>{{ $barangmasuk->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <button type="button" class="btn btn-success btn-sm me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editBarangModal{{ $barangmasuk->id }}">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </button>
                                                        <form
                                                            action="{{ route('barangmasuk.destroy', ['barangmasuk' => $barangmasuk->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm me-2 btn-delete"
                                                                data-name="{{ $barangmasuk->nama }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                        <!-- Modal Edit Barang Masuk -->
                                        @foreach ($barangmasuks as $barangmasuk)
                                            <div class="modal fade" id="editBarangModal{{ $barangmasuk->id }}"
                                                tabindex="-1" aria-labelledby="editBarangModalLabel{{ $barangmasuk->id }}"
                                                aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title"
                                                                id="editBarangModalLabel{{ $barangmasuk->id }}">Edit Barang
                                                                Masuk</h5>
                                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                                aria-label="Close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form
                                                                action="{{ route('barangmasuk.update', $barangmasuk->id) }}"
                                                                method="POST">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mb-3">
                                                                    <label for="stok_barang_id" class="form-label">Nama
                                                                        Barang</label>
                                                                    <select class="form-control" id="stok_barang_id"
                                                                        name="stok_barang_id" required>
                                                                        @foreach ($stock as $item)
                                                                            <option value="{{ $item->id }}"
                                                                                {{ $item->id == $barangmasuk->stok_barang_id ? 'selected' : '' }}>
                                                                                {{ $item->nama }} - (Stok:
                                                                                {{ $item->stock }})
                                                                            </option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="jumlah" class="form-label">Jumlah</label>
                                                                    <input type="number" class="form-control"
                                                                        id="jumlah" name="jumlah"
                                                                        value="{{ $barangmasuk->jumlah }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="tgl" class="form-label">Tanggal
                                                                        Masuk</label>
                                                                    <input type="date" class="form-control"
                                                                        id="tgl" name="tgl"
                                                                        value="{{ $barangmasuk->tgl }}" required>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="keterangan"
                                                                        class="form-label">Keterangan</label>
                                                                    <textarea class="form-control" id="keterangan" name="keterangan">{{ $barangmasuk->keterangan }}</textarea>
                                                                </div>
                                                                <button type="submit"
                                                                    class="btn btn-primary">Update</button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>

    <!-- Modal Tambah Barang -->
    <div class="modal fade" id="tambahBarangModal" tabindex="-1" aria-labelledby="tambahBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahBarangModalLabel">Tambahkan Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="tambahBarangForm" action="{{ route('barangmasuk.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="stok_barang_id" class="form-label">Nama Barang</label>
                            <select class="form-control" id="stock_barang_id" name="stock_barang_id" required>
                                @foreach ($stock as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} - (Stok:
                                        {{ $item->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jumlah" class="form-label">Jumlah</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <div class="mb-3">
                            <label for="tgl" class="form-label">Tanggal Masuk</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" required>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

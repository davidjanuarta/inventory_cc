@extends('layouts.app')

@push('scripts')
<script type="module">
    $(document).ready(function() {
        $('#stockTable').DataTable();
        $(".datatable").on("click", ".btn-delete", function(e) {
            e.preventDefault();

            var form = $(this).closest("form");
            var name = $(this).data("name");

            Swal.fire({
                title: "Are you sure want to delete\n" + name + "?",
                text: "You won't be able to revert this!",
                icon: "warning",
                showCancelButton: true,
                confirmButtonClass: "bg-primary",
                confirmButtonText: "Yes, delete it!",
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
                        <h1 class="h3 mb-0 text-gray-800">Stock Barang</h1>
                        <ul class="list-inline mb-0 float-end">
                            <li class="list-inline-item">
                                <a href="{{ route('stock.exportPdf') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm"><i
                                        class="fas fa-download fa-sm text-white-50"></i> Download PDF</a>
                                <a href="{{ route('stock.exportExcel') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-success shadow-sm"><i
                                        class="fas fa-download fa-sm text-white-50"></i> Download Excel</a>
                                <a href="#" data-bs-toggle="modal" data-bs-target="#tambahBarangModal"
                                    class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                                        class="fas fa-plus fa-sm text-white-50"></i> Tambahkan</a>
                            </li>
                        </ul>
                    </div>
                    <div class="container-fluid pt-2 px-2">
                        <div class="bg-white justify-content-between rounded shadow p-4">
                            <div class="table-responsive">
                                <table class="table table-bordered align-middle table-hover table-striped mb-0 datatable"
                                    id="stockTable" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Gambar</th>
                                            <th>Nama</th>
                                            <th>Jenis</th>
                                            <th>Merk</th>
                                            <th>Ukuran</th>
                                            <th>Stock</th>
                                            <th>Satuan</th>
                                            <th>Lokasi</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($stock as $index => $stock)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>
                                                    @if ($stock->gambar)
                                                        <img src="{{ asset('storage/' . $stock->gambar) }}"
                                                            alt="{{ $stock->nama }}" style="width: 50px; height: 50px;">
                                                    @else
                                                        <span>Tidak ada gambar</span>
                                                    @endif
                                                </td>
                                                <td>{{ $stock->nama }}</td>
                                                <td>{{ $stock->jenis }}</td>
                                                <td>{{ $stock->merk }}</td>
                                                <td>{{ $stock->ukuran }}</td>
                                                <td>{{ $stock->stock }}</td>
                                                <td>{{ $stock->satuan }}</td>
                                                <td>{{ $stock->lokasi }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <!-- Tombol Edit -->
                                                        <button type="button" class="btn btn-success btn-sm me-2"
                                                            data-bs-toggle="modal"
                                                            data-bs-target="#editBarangModal{{ $stock->id }}">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </button>
                                                        <!-- Tombol Delete -->
                                                        <form
                                                            action="{{ route('stock.destroy', ['stock' => $stock->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm me-2 btn-delete"
                                                                data-name="{{ $stock->nama }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    </div>

                                                    <!-- Modal Edit Barang -->
                                                    <div class="modal fade" id="editBarangModal{{ $stock->id }}"
                                                        tabindex="-1"
                                                        aria-labelledby="editBarangModalLabel{{ $stock->id }}"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title"
                                                                        id="editBarangModalLabel{{ $stock->id }}">Edit
                                                                        Barang</h5>
                                                                    <button type="button" class="btn-close"
                                                                        data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form action="{{ route('stock.update', $stock->id) }}"
                                                                        method="POST" enctype="multipart/form-data">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <div class="mb-3">
                                                                            <label for="nama" class="form-label">Nama
                                                                                Barang</label>
                                                                            <input type="text" class="form-control"
                                                                                id="nama" name="nama"
                                                                                value="{{ old('nama', $stock->nama) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="jenis"
                                                                                class="form-label">Jenis</label>
                                                                            <input type="text" class="form-control"
                                                                                id="jenis" name="jenis"
                                                                                value="{{ old('jenis', $stock->jenis) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="merk"
                                                                                class="form-label">Merk</label>
                                                                            <input type="text" class="form-control"
                                                                                id="merk" name="merk"
                                                                                value="{{ old('merk', $stock->merk) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="ukuran"
                                                                                class="form-label">Ukuran</label>
                                                                            <input type="text" class="form-control"
                                                                                id="ukuran" name="ukuran"
                                                                                value="{{ old('ukuran', $stock->ukuran) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="stock"
                                                                                class="form-label">Stock</label>
                                                                            <input type="number" class="form-control"
                                                                                id="stock" name="stock"
                                                                                value="{{ old('stock', $stock->stock) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="satuan"
                                                                                class="form-label">Satuan</label>
                                                                            <input type="text" class="form-control"
                                                                                id="satuan" name="satuan"
                                                                                value="{{ old('satuan', $stock->satuan) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="lokasi"
                                                                                class="form-label">Lokasi</label>
                                                                            <input type="text" class="form-control"
                                                                                id="lokasi" name="lokasi"
                                                                                value="{{ old('lokasi', $stock->lokasi) }}"
                                                                                required>
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="gambar"
                                                                                class="form-label">Gambar
                                                                                (Opsional)
                                                                            </label>
                                                                            <input type="file" class="form-control"
                                                                                id="gambar" name="gambar">
                                                                            @if ($stock->gambar)
                                                                                <img src="{{ asset('storage/' . $stock->gambar) }}"
                                                                                    alt="{{ $stock->nama }}"
                                                                                    style="width: 100px; height: 100px; margin-top: 10px;">
                                                                            @endif
                                                                        </div>
                                                                        <button type="submit"
                                                                            class="btn btn-primary">Update</button>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
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
                    <h5 class="modal-title" id="tambahBarangModalLabel">Tambah Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('stock.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <label for="nama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="nama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="jenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="jenis" name="jenis" required>
                        </div>
                        <div class="mb-3">
                            <label for="merk" class="form-label">Merk</label>
                            <input type="text" class="form-control" id="merk" name="merk" required>
                        </div>
                        <div class="mb-3">
                            <label for="ukuran" class="form-label">Ukuran</label>
                            <input type="text" class="form-control" id="ukuran" name="ukuran" required>
                        </div>
                        <div class="mb-3">
                            <label for="stock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="stock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="satuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="satuan" name="satuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="lokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="lokasi" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="gambar" class="form-label">Gambar (Opsional)</label>
                            <input type="file" class="form-control" id="gambar" name="gambar">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal Edit Barang -->
    <!-- Modal Edit Barang -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editBarangForm" action="" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="id" id="editBarangId">
                        <div class="mb-3">
                            <label for="editNama" class="form-label">Nama Barang</label>
                            <input type="text" class="form-control" id="editNama" name="nama" required>
                        </div>
                        <div class="mb-3">
                            <label for="editJenis" class="form-label">Jenis</label>
                            <input type="text" class="form-control" id="editJenis" name="jenis" required>
                        </div>
                        <div class="mb-3">
                            <label for="editMerk" class="form-label">Merk</label>
                            <input type="text" class="form-control" id="editMerk" name="merk" required>
                        </div>
                        <div class="mb-3">
                            <label for="editUkuran" class="form-label">Ukuran</label>
                            <input type="text" class="form-control" id="editUkuran" name="ukuran" required>
                        </div>
                        <div class="mb-3">
                            <label for="editStock" class="form-label">Stock</label>
                            <input type="number" class="form-control" id="editStock" name="stock" required>
                        </div>
                        <div class="mb-3">
                            <label for="editSatuan" class="form-label">Satuan</label>
                            <input type="text" class="form-control" id="editSatuan" name="satuan" required>
                        </div>
                        <div class="mb-3">
                            <label for="editLokasi" class="form-label">Lokasi</label>
                            <input type="text" class="form-control" id="editLokasi" name="lokasi" required>
                        </div>
                        <div class="mb-3">
                            <label for="editGambar" class="form-label">Gambar (Opsional)</label>
                            <input type="file" class="form-control" id="editGambar" name="gambar">
                        </div>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

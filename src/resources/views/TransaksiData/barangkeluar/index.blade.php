@extends('layouts.app')

@push('scripts')
    <script type="module">
        $(document).ready(function() {
            $('#barangKeluar').DataTable();
            $('#editBarangModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var id = button.data('id');
                var tgl = button.data('tgl');
                var jumlah = button.data('jumlah');
                var penerima = button.data('penerima');
                var keterangan = button.data('keterangan');

                var modal = $(this);
                modal.find('.modal-body #tgl').val(tgl);
                modal.find('.modal-body #jumlah').val(jumlah);
                modal.find('.modal-body #penerima').val(penerima);
                modal.find('.modal-body #keterangan').val(keterangan);

                // Update form action URL with the item's ID
                var form = modal.find('#editBarangForm');
                form.attr('action', '/barangkeluar/' + id);
            });
            
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
                        <h1 class="h3 mb-0 text-gray-800">Barang Keluar</h1>
                        <ul class="list-inline mb-0 float-end">
                            <li class="list-inline-item">
                                <a href="{{ route('barangkeluar.exportPdfbk') }}"
                                    class="d-none d-sm-inline-block btn btn-sm btn-danger shadow-sm">
                                    <i class="fas fa-download fa-sm text-white-50"></i> Download PDF
                                </a>
                                <a href="{{ route('barangkeluar.exportExcelbk') }}"
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
                                <table class="table table-bordered align-middle table-hover table-striped mb-0 datatable"
                                    id="barangKeluar" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Tanggal Keluar</th>
                                            <th>Nama Barang</th>
                                            <th>Jenis</th>
                                            <th>Merk</th>
                                            <th>Ukuran</th>
                                            <th>Jumlah Keluar</th>
                                            <th>Penerima</th>
                                            <th>Keterangan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($barangkeluars as $index => $barangkeluar)
                                            <tr>
                                                <td>{{ $index + 1 }}</td>
                                                <td>{{ $barangkeluar->tgl }}</td>
                                                <td>{{ $barangkeluar->stokBarang->nama ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangkeluar->stokBarang->jenis ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangkeluar->stokBarang->merk ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangkeluar->stokBarang->ukuran ?? 'Tidak Ditemukan' }}</td>
                                                <td>{{ $barangkeluar->jumlah }}</td>
                                                <td>{{ $barangkeluar->penerima }}</td>
                                                <td>{{ $barangkeluar->keterangan }}</td>
                                                <td>
                                                    <div class="d-flex align-items-center">
                                                        <button class="btn btn-success btn-sm me-2" data-bs-toggle="modal"
                                                            data-bs-target="#editBarangModal"
                                                            data-id="{{ $barangkeluar->id }}"
                                                            data-tgl="{{ $barangkeluar->tgl }}"
                                                            data-jumlah="{{ $barangkeluar->jumlah }}"
                                                            data-penerima="{{ $barangkeluar->penerima }}"
                                                            data-keterangan="{{ $barangkeluar->keterangan }}">
                                                            <i class="fas fa-pencil-alt"></i> Edit
                                                        </button>
                                                        <form
                                                            action="{{ route('barangkeluar.destroy', ['barangkeluar' => $barangkeluar->id]) }}"
                                                            method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <button type="submit"
                                                                class="btn btn-danger btn-sm me-2 btn-delete"
                                                                data-name="{{ $barangkeluar->nama }}">
                                                                <i class="fas fa-trash"></i> Delete
                                                            </button>
                                                        </form>
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
                    <h5 class="modal-title" id="tambahBarangModalLabel">Tambahkan Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('barangkeluar.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="stok_barang_id">Nama Barang</label>
                            <select class="form-control" id="stock_barang_id" name="stock_barang_id" required>
                                @foreach ($stock as $item)
                                    <option value="{{ $item->id }}">{{ $item->nama }} - (Stok: {{ $item->stock }})
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mt-3">
                            <label for="jumlah">Jumlah Keluar</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="tgl">Tanggal Keluar</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="penerima">Penerima</label>
                            <input type="text" class="form-control" id="penerima" name="penerima" required>
                        </div>

                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Edit Barang -->
    <div class="modal fade" id="editBarangModal" tabindex="-1" aria-labelledby="editBarangModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editBarangModalLabel">Edit Barang Keluar</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('barangkeluar.update', ['barangkeluar' => $barangkeluar->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="tgl">Tanggal Keluar</label>
                            <input type="date" class="form-control" id="tgl" name="tgl" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="jumlah">Jumlah Keluar</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="penerima">Penerima</label>
                            <input type="text" class="form-control" id="penerima" name="penerima" required>
                        </div>
                        <div class="form-group mt-3">
                            <label for="keterangan">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

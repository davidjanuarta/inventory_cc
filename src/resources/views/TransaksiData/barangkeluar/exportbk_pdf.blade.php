<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Employee List</title>
    <style>
        html {
            font-size: 12px;
        }

        .table {
            border-collapse: collapse !important;
            width: 100%;
        }

        .table-bordered th,
        .table-bordered td {
            padding: 0.5rem;
            border: 1px solid black !important;
        }
    </style>
</head>

<body>
    <h1>Barang Keluar</h1>
    <table class="table table-bordered">
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
            </tr>
        </thead>
        <tbody>
            @foreach ($barangkeluar as $index => $barangkeluar)
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
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

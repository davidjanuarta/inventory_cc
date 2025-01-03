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
    <h1>Barang Masuk</h1>
    <table class="table table-bordered">
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
            </tr>
        </thead>
        <tbody>
            @foreach ($barangmasuk as $index => $barangmasuk)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $barangmasuk->tgl }}</td>
                    <td>{{ $barangmasuk->stokBarang->nama ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $barangmasuk->stokBarang->jenis ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $barangmasuk->stokBarang->merk ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $barangmasuk->stokBarang->ukuran ?? 'Tidak Ditemukan' }}</td>
                    <td>{{ $barangmasuk->jumlah }}</td>
                    <td>{{ $barangmasuk->keterangan }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

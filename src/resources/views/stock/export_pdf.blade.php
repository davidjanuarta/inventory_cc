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
    <h1>STOCK BARANG</h1>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>No</th>
                <th>Nama</th>
                <th>Jenis</th>
                <th>Merk</th>
                <th>Ukuran</th>
                <th>Stock</th>
                <th>Satuan</th>
                <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($stock as $index => $stock)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $stock->nama }}</td>
                    <td>{{ $stock->jenis }}</td>
                    <td>{{ $stock->merk }}</td>
                    <td>{{ $stock->ukuran }}</td>
                    <td>{{ $stock->stock }}</td>
                    <td>{{ $stock->satuan }}</td>
                    <td>{{ $stock->lokasi }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>

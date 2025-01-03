<table>
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

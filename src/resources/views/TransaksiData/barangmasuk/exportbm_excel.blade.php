<table>
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

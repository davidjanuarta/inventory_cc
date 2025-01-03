<table>
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

<table border="1">
    <tr>
        <th>ID</th>
        <th>NIM</th>
        <th>Nama</th>
        <th>Jurusan</th>
    </tr>

    @foreach($mahasiswa as $item)
    <tr>
        <td>{{ $item->id_mahasiswa }}</td>
        <td>{{ $item->nim }}</td>
        <td>{{ $item->nama }}</td>
        <td>{{ $item->detail_jurusan->nama_jurusan ?? $item->jurusan ?? '-' }}</td>
    </tr>
    @endforeach
</table>

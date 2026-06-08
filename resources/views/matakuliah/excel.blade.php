<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Mata Kuliah</th>
        <th>SKS</th>
        <th>Jurusan</th>
    </tr>

    @foreach($matakuliah as $item)
    <tr>
        <td>{{ $item->id_matakuliah }}</td>
        <td>{{ $item->nama_matakuliah }}</td>
        <td>{{ $item->sks }}</td>
        <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
    </tr>
    @endforeach
</table>

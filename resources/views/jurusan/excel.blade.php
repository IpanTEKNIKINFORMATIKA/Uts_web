<table border="1">
    <tr>
        <th>ID</th>
        <th>Nama Jurusan</th>
        <th>Akreditasi</th>
    </tr>

    @foreach($jurusan as $item)
    <tr>
        <td>{{ $item->id_jurusan }}</td>
        <td>{{ $item->nama_jurusan }}</td>
        <td>{{ $item->akreditasi ?? '-' }}</td>
    </tr>
    @endforeach
</table>

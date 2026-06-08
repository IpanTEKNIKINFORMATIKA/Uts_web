<!DOCTYPE html>
<html>
<head>
    <title>Data Mata Kuliah</title>
</head>
<body onload="window.print()">
    <h2>Data Mata Kuliah</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Nama Mata Kuliah</th>
            <th>SKS</th>
            <th>Jurusan</th>
        </tr>
        @foreach($matakuliah as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_matakuliah }}</td>
            <td>{{ $item->sks }}</td>
            <td>{{ $item->jurusan->nama_jurusan ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

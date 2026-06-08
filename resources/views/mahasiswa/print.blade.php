<!DOCTYPE html>
<html>
<head>
    <title>Data Mahasiswa</title>
</head>
<body onload="window.print()">
    <h2>Data Mahasiswa</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <tr>
            <th>No</th>
            <th>NIM</th>
            <th>Nama</th>
            <th>Jurusan</th>
        </tr>
        @foreach($mahasiswa as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nim }}</td>
            <td>{{ $item->nama }}</td>
            <td>{{ $item->detail_jurusan->nama_jurusan ?? $item->jurusan ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

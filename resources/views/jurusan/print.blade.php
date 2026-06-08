<!DOCTYPE html>
<html>
<head>
    <title>Data Jurusan</title>
</head>
<body onload="window.print()">
    <h2>Data Jurusan</h2>
    <table border="1" width="100%" cellspacing="0" cellpadding="5">
        <tr>
            <th>No</th>
            <th>Nama Jurusan</th>
            <th>Akreditasi</th>
        </tr>
        @foreach($jurusan as $item)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $item->nama_jurusan }}</td>
            <td>{{ $item->akreditasi ?? '-' }}</td>
        </tr>
        @endforeach
    </table>
</body>
</html>

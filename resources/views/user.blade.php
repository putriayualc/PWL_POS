<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <table border="1" cellpadding="2" cellspacing="0">
        <tr>
            {{-- <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th> --}}
            <th>Jumlah Pengguna</th>
        </tr>
        {{-- @foreach ($data as $d) --}}
        <tr>
            {{-- <td>{{ $data->user_id}}</td>
            <td>{{ $data->username}}</td>
            <td>{{ $data->nama}}</td>
            <td>{{ $data->level_id}}</td> --}}
            <td>{{ $data }}</td>
        </tr>
        {{-- @endforeach --}}
    </table>
</body>
</html>
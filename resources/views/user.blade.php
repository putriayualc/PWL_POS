<!DOCTYPE html>
<html lang="en">
<head>
    <title>Data User</title>
</head>
<body>
    <h1>Data User</h1>
    <a href="/user/tambah">+ Tambah User</a>
    <table border="1" cellpadding="2" cellspacing="0">
        {{-- <tr>
            <th>ID</th>
            <th>Username</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th> --}}
            {{-- <th>Jumlah Pengguna</th> --}}
        {{-- </tr> --}}
        {{-- @foreach ($data as $d) --}}
        {{-- <tr>
            <td>{{ $data->user_id}}</td>
            <td>{{ $data->username}}</td>
            <td>{{ $data->nama}}</td>
            <td>{{ $data->level_id}}</td> --}}
            {{-- <td>{{ $data }}</td> --}}
        {{-- </tr> --}}
        {{-- @endforeach --}}

        <tr>
            <th>ID</th>
            <th>Usernama</th>
            <th>Nama</th>
            <th>ID Level Pengguna</th>
            <th>Aksi</th>
        </tr>
        @foreach ($data as $d)
            <tr>
            <td>{{ $d->user_id }}</td>
            <td>{{ $d->username }}</td>
            <td>{{ $d->nama }}</td>
            <td>{{ $d->level_id }}</td>
            <td>
                <a href="/user/ubah/{{ $d->user_id }}">Ubah</a>
                <a href="/user/hapus/{{ $d->user_id }}">Hapus</a>
            </td>
        </tr>
        @endforeach
    </table>
</body>
</html>
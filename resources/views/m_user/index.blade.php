@extends('layout.app')

@section('subtitle', 'crud User')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'CRUD USER')

@section('content')
<div class="card card-secondary">
    <div class="card-header bg-light">
        <div class="row">
            <div class="col-lg-12 margin-tb">
                <div class="float-left">
                    <h1 style="font-size: 1.5rem;">CRUD User</h1>
                </div>
                <div class="float-right">
                    <a class="btn btn-primary" href="{{ route('m_user.create') }}">Tambah User</a>
                </div>
            </div>
        </div>
    </div>
    <div class="card-body">
        @if ($message = Session::get('success'))
        <div class="alert alert-success">
            <p>{{ $message }}</p>
        </div>
        @endif
        <table class="table table-bordered">
            <tr>
                <th width="20px" class="text-center">User id</th>
                <th width="20px" class="text-center">Level id</th>
                <th width="90px" class="text-center">Username</th>
                <th width="100px" class="text-center">Nama</th>
                <th width="100px" class="text-center">Password</th>
                <th width="100px" class="text-center">Actions</th>
            </tr>
            @foreach ($useri as $m_user)
            <tr>
                <td>{{ $m_user->user_id }}</td>
                <td>{{ $m_user->level_id }}</td>
                <td>{{ $m_user->username }}</td>
                <td>{{ $m_user->nama }}</td> 
                {{-- <td>{{ $m_user->password }}</td> --}}
                <td>{{ substr($m_user->password, 0, 10) }}</td>
                <td class="text-center">
                    <form action="{{ route('m_user.destroy',$m_user->user_id) }}" method="POST">
                        <a class="btn btn-info btn-sm" href="{{ route('m_user.show', $m_user->user_id) }}">Show</a>
                        <a class="btn btn-primary btn-sm" href="{{ route('m_user.edit', $m_user->user_id) }}">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus data ini?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </table>
    </div>
</div>
@endsection
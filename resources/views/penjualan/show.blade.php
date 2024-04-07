@extends('layouts.template')
@section('content')
<div class="card card-outline card-primary">
    <div class="card-header">
        <h3 class="card-title">{{ $page->title }}</h3>
        <div class="card-tools"></div>
    </div>
    <div class="card-body">
        @empty($detail)
        <div class="alert alert-danger alert-dismissible">
            <h5><i class="icon fas fa-ban"></i> Kesalahan!</h5>
            Data yang Anda cari tidak ditemukan.
        </div>
        @else
        <table class="table table-bordered table-striped table-hover table-sm">
            <tr>
                <th>ID</th>
                <td>{{ $detail->detail_id }}</td>
            </tr>
            <tr>
                <th>Pembeli</th>
                <td>{{ $detail->sale->pembeli }}</td>
            </tr>
            <tr>
                <th>Barang</th>
                <td>{{ $detail->barang->barang_nama }}</td>
            </tr>
            <tr>
                <th>Tanggal Penjualan</th>
                <td>{{ $detail->sale->penjualan_tanggal }}</td>
            </tr>
            <tr>
                <th>Jumlah Barang</th>
                <td>{{ $detail->jumlah}}</td>
            </tr>
            <tr>
                <th>Total</th>
                <td>{{ $detail->harga}}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{ $detail->created_at}}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{ $detail->updated_at}}</td>
            </tr>
        </table>
        @endempty
        <a href="{{ url('penjualan') }}" class="btn btn-sm btn-default mt-2">Kembali</a>
    </div>
</div>
@endsection

@push('css')
@endpush

@push('js')
@endpush

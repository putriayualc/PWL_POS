@extends('layout.app')

{{-- Customize layout section --}}

@section('subtitle','Kategori')
@section('content_header_title','Home')
@section('content_header_subtitle','Kategori')

@section('content')
    <div class="container">
        <div class="card">
            <div class="card-header">Manage Kategori</div>
            
            <div class="card-body">
                <div class="mb-2">
                    <a href="/kategori/create" class="btn btn-outline-dark">+ Add</a>
                </div>
                {{ $dataTable->table() }}
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
@endpush
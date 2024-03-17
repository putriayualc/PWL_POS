@extends('layout.app')

{{--Customize layout section--}}

@section('subtitle','Welcome')
@section('content_header_title','Home')
@section('content_header_subtitle','Welcome')

{{-- Content body: main page content --}}

@section('content_body')
    <p>Welcome to this beautiful admin panel</p>
@stop

{{-- Push extra css --}}

@push('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@endpush

{{-- Push extra scripts --}}

@push('js')
    <script> console.log("Hi, I'm using the laravel-AdminLTE package!");</script>
@endpush
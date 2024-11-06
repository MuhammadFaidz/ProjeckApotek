@extends('layouts.layout')

@section('content')
    <div class="jumbotron py-4 px-5">
        <h1 class="display-4">
            Selamat Datang {{ Auth::user()->name }}...
        </h1>
        <hr class="my-4">
        <p>Aplikasi ini di gunakan hanya oleh pegawai adminstrator APOTEK, Digunakan untuk mengelola data obat, Penyetokan,
            juga (kasir).</p>
    </div>
@endsection

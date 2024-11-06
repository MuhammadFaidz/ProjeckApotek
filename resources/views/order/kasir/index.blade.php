@extends('layouts.layout')

@section('content')
    <div class="container mt-3">
        <div class="d-flex justify-content-end">
            <a href="{{ route('kasir.order.tambah.pembelian') }}" class="btn btn-primary">pembeli NEW</a>
        </div>
    </div>
@endsection

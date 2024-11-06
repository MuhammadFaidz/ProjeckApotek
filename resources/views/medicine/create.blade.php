@extends('layouts.layout')

@section('content')
    <form action="{{ route('medicines.store')}}" method="POST" class="card p-5">
        {{-- 
            1. tag <form> attr action & method
                method : 
                - GET : form tujuan mencari data (search)
                - POST : form tujuan menambahkan/menghapus/mengubah
                action : route memproses data
                - arahkan route yg akan menangani proses data ke db nya
                - jika GET : arahkan ke route yg sama dengan route yg menampilkan blade ini
                - jika POST : arahkan ke route baru dengan httpmethod sesuai tujuan POST (tambah), PATCH (ubah), DELETE (hapus) 
            2. jika form method POST : @csrf
            3. input attr name (isi disamakan dengan column di migration)
            4. button/input type submit
        --}}
        @csrf
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat: </label>
            <div class="col-sm-10">
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat: </label>
            <div class="col-sm-10">
                <select class="form-select" name="type" id="type">
                    <option selected disabled hidden>Pilih</option>
                    <option value="tablet" {{ old('type') == 'tablet' ? 'selected' : '' }}>Tablet</option>
                    <option value="kapsul" {{ old('type') == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
                    <option value="sirup" {{ old('type') == 'sirup' ? 'selected' : '' }}>Sirup</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stock: </label>
            <div class="col-sm-10">
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Kirim</button>
    </form>
@endsection

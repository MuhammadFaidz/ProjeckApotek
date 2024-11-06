@extends('layouts.layout')

@section('content')
    {{-- action ke patch, mengirim {id} --}}
    <form action="{{ route('medicines.update', $medicine['id']) }}" method="POST">
        @csrf
        @method('PATCH')
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif
        <div class="form-group">
            <label for="name" class="form-label">Nama Obat : </label>
            {{-- value menampilkan isi di input, isi di input sesuai dengan data yg diambil di controller $medicine --}}
            <input type="text" name="name" id="name" value="{{ $medicine['name'] }}" class="form-control">
            {{-- jika ada error yg berhubungan dengan field name, munculkan teks error disini --}}
            @error('name')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="type" class="form-label">Tipe Obat :</label>
            <select name="type" id="type" class="form-select">
                {{-- jika $medicine['type'] merupakan tablet ? tambah selected (opsi akan terpilih), jika tidak : tidak ditambahkan apapun --}}
                <option value="tablet" {{ $medicine['type'] == 'tablet' ? 'selected' : '' }}>Tablet</option>
                <option value="sirup" {{ $medicine['type'] == 'sirup' ? 'selected' : '' }}>Sirup</option>
                <option value="kapsul" {{ $medicine['type'] == 'kapsul' ? 'selected' : '' }}>Kapsul</option>
            </select>
            @error('type')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <div class="form-group">
            <label for="price" class="form-label">Harga : </label>
            <input type="number" name="price" id="price" value="{{ $medicine['price'] }}" class="form-control">
            @error('price')
                <small class="text-danger">{{ $message }}</small>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
    </form>
@endsection

@extends('layouts.layout')

@section('content')
    <div class="container mt-4">
        <h2>Edit Pengguna</h2>
        <form action="{{ route('user.update', $user->id) }}" method="POST">
            @csrf
            @method('PATCH')

            <div class="form-group mt-2">
                <label for="name">Nama:</label>
                <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control"
                    required>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group mt-2">
                <label for="role">Role:</label>
                <input type="text" name="role" id="role" value="{{ $user->role }}" class="form-control"
                    required>
                @error('role')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary mt-3">Simpan Perubahan</button>
        </form>
    </div>
@endsection

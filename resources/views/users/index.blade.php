@extends('layouts.layout')

@section('content')
    <div class="container">
        {{-- Flash Messages --}}
        @foreach (['success', 'failed'] as $msg)
            @if (Session::get($msg))
                <div class="alert alert-{{ $msg == 'success' ? 'success' : 'danger' }}">
                    {{ Session::get($msg) }}
                </div>
            @endif
        @endforeach

        <a href="{{ route('user.create') }}" class="btn btn-success">Tambah Pengguna</a>

        <table class="table table-bordered table-striped mt-3">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $index => $user)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->role }}</td>
                        <td>
                            <a href="{{ route('user.edit', $user->id) }}" class="btn btn-warning btn-sm">Edit</a>

                            <button onclick="showModal('delete', {{ $user->id }}, '{{ $user->name }}')"
                                class="btn btn-danger btn-sm">Hapus</button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">Data Pengguna Kosong</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Modal untuk Edit --}}
    <div class="modal fade" id="modalEdit" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                @method('PATCH')
                <div class="modal-header">
                    <h1 class="modal-title">Edit Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h5 id="user_name"></h5>
                    <div class="form-group">
                        <label for="email">Email Baru:</label>
                        <input type="email" name="email" id="email" class="form-control" required>

                        @if (Session::get('failed'))
                            <small class="text-danger">{{ Session::get('failed') }}</small>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-warning">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal untuk Delete --}}
    <div class="modal fade" id="modalDelete" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <form class="modal-content" method="POST" action="">
                @csrf
                @method('DELETE')
                <div class="modal-header">
                    <h1 class="modal-title">Hapus Pengguna</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p>Apakah Anda yakin ingin menghapus <strong id="delete_user_name"></strong>?</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-danger">Hapus</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script>
        function showModal(type, id, name = '') {
            let modal = type === 'delete' ? '#modalDelete' : '#modalEdit';
            let url = type === 'delete' ?
                "{{ route('user.delete', ':id') }}" :
                "{{ route('user.update', ':id') }}";

            $(modal).modal('show');
            $(modal).find('form').attr('action', url.replace(':id', id));

            if (type === 'delete') {
                $(modal).find('#delete_user_name').text(name);
            } else {
                $(modal).find('#user_name').text('Edit pengguna: ' + name);
            }
        }

        @if (Session::get('failed'))
            showModal('edit', "{{ Session::get('id') }}", "{{ Session::get('name') }}");
        @endif
    </script>
    </script>
@endpush

@extends('layouts.layout')

@section('content')
    <div class="container">
        {{-- Session::get mengambil pesan pada return redirect bagian with pada controller --}}
        @if (Session::get('success'))
            <div class="alert alert-success">{{ Session::get('success') }}</div>
        @endif
        @if (Session::get('failed'))
            <div class="alert alert-danger">{{ Session::get('failed') }}</div>
        @endif

        <form action="" method="GET" class="d-flex justify-content-end">
            <input type="text" name="search_medicine" placeholder="Cari nama obat..." class="form-control">
            <button type="submit" class="btn btn-primary ms-2">Cari</button>
        </form>

        <table class="table table-bordered table-stripped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Obat</th>
                    <th>Tipe</th>
                    <th>Harga</th>
                    <th>Stok</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @if (!is_null($medicines) && count($medicines) < 1)
                    <tr>
                        <td colspan="6" class="text-center">Data Obat Kosong</td>
                    </tr>
                @else
                    @foreach ($medicines as $index => $item)
                        <tr>
                            <td>{{ ($medicines->currentPage()-1) * ($medicines->perPage()) + ($index+1) }}</td>
                            <td>{{ $item['name'] }}</td>
                            <td>{{ $item['type'] }}</td>
                            <td>Rp. {{  number_format($item['price'], 0, ',', '.') }}</td>
                            <td style="cursor: pointer" class="{{ $item['stock'] <= 3 ? 'bg-danger text-white' : '' }}" onclick="showModalStock('{{ $item->id }}','{{ $item->name }}','{{ $item->stock }}')">{{ $item['stock'] }}</td>
                            <td class="d-flex">
                                {{-- , $item['id'] pada route akan mengisi path dinamis {id} --}}
                                <a href="{{ route('medicines.edit', $item['id']) }}" class="btn btn-primary me-2">Edit</a>
                                <button class="btn btn-danger" onclick="showModalDelete('{{ $item->id }}',
                                '{{ $item->name }}')">Hapus</button>
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>

        <div class="d-flex justify-content-end my-3">{{ $medicines->links() }}</div>
    </div>
    <!-- Modal -->
<div class="modal fade" id="modalDelete" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="">
            @csrf   
            {{-- mengganti method "post" menjadi delete agar sesuai dengan route web.php::delete() --}}
            @method('DELETE')
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">hapus obat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
            Apakah anda yakin ingin menghapus obat! <b id="name-medicine"></b>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Hapus</button>
            </div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalEditStock" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form class="modal-content" method="POST" action="">
            @csrf   
            @method('PATCH')
            <div class="modal-header">
                <h1 class="modal-title" id="exampleModalLabel">Edit Stock obat</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h5 id="title_from_edit"></h5>
                <div class="form-group">
                    <label class="form-label" for="stock">Stock Sebelumnya : </label>
                    <input type="number" name="stock" id="stock" class="form-control">

                    @if (session::get('failed'))
                        <small class="text-danger">{{ session::get('failed') }}</small>
                    @endif
                </div>
            </div>
            <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
            <button type="submit" class="btn btn-danger">Edit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('script')

<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
<script>
    function showModalDelete(id,name) {
        //mengisi html bagian id="name-medicine" dengan text dari parameter name
        $("#name-medicine").text(name);
        //tampilkan modal dengan id="ModalDelete"
        $("#modalDelete").modal('show');
        //action di isi melalui js karna id dikirm ke js, id akan diisi ke route delete{id}
        let url = "{{ route('medicines.delete', ':id') }}";
        //ganti :id dengan id yang dikirim dari parameter
        url = url.replace(':id',id);
        //masukan url yang sudah di isi id ke action form
        $("form").attr('action',url);
    }

    function showModalStock(id,name,stock) {
        $("#title_form_edit").text(name);
        $("#stock").val(stock);
        $("#modalEditStock").modal('show');
        let url = "{{ route('medicines.update.stock', ':id') }}";
        url = url.replace(':id',id);
        $("form").attr('action',url);
    }

    @if (session::get('failed'))
        let id ="{{ session::get('id') }}";
        let name = "{{ session::get('name') }}";
        let stock = "{{ session::get('stock') }}";
        showModalStock(id, name, stock);
    @endif
</script>



@endpush
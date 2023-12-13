@extends('layouts.template')

@section('content')
<div id="msg-success"></div>

<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Stok</td>
            <td class="text-center">Aksi</td>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($medicines as $item)
            <tr>
                <td>{{ $no }}</td>
                <td>{{ $item->name }}</td>
                <td style="{{ $item->stock <= 3 ? 'background: red; color: white;' : 'background: none; color: black;' }}">{{ $item->stock }}</td>
                <td class="d-flex justify-content-center">
                    <a href="#" onclick="edit('{{ $item->id }}')" class="btn btn-primary mx-3">Tambah Stok</a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>

<div class="modal fade" tabindex="-1" id="edit-stock">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Ubah Data Stok</h5>
                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="close"></button>
            </div>
            <form action="" method="post" id="form-stock">
                <div class="modal-body">
                    <div id="msg"></div>

                    <input type="hidden" name="id" id="id">
                    <div class="mb-3">
                        <label for="name" class="form-label">Nama Obat :</label>
                        <input type="text" name="name" id="name" class="form-control" disabled>
                    </div>
                    <div class="mb-3">
                        <label for="stock" class="form-label">Stok Obat :</label>
                        <input type="number" name="stock" id="stock" class="form-control">
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('script')
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        })

        function edit(id) {
            var url = "{{ route('medicine.stock.edit', ':id') }}"
            url = url.replace(':id', id)
            $.ajax({
                type: "GET",
                url: url,
                dataType: 'json',
                success: function (res) {
                    $('#edit-stock').modal('show')
                    $('#id').val(res.id)
                    $('#name').val(res.name)
                    $('#stock').val(res.stock)
                }
            })
        }

        $('#form-stock').submit(function (e) {
            e.preventDefault()

            var id = $('#id').val()
            var urlForm = "{{ route('medicine.stock.update', ':id') }}"
            urlForm = urlForm.replace(':id', id)

            var data = {
                stock: $('#stock').val()
            }

            $.ajax({
                type: 'PATCH',
                url: urlForm,
                data: data,
                cache: false,
                success: (data) => {
                    $('#edit-stock').modal('hide')
                    sessionStorage.reloadAfterPageLoad = true;
                    window.location.reload()
                },
                error: (data) => {
                    $('#edit-stock').modal('show')
                    $('#msg').attr('class', 'alert alert-danger')
                    $('#msg').text(data.responseJSON.message)
                }
            })
        })

        $(function () {
            if (sessionStorage.reloadAfterPageLoad) {
                $('#msg-success').attr('class', 'alert alert-success')
                $('#msg-success').text('Berhasil menambahkan data stock')
                sessionStorage.clear()
            }
        })
    </script>
@endpush

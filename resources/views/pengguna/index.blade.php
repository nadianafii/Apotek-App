@extends('layouts.template')

@section('content')
@if (Session::get('success'))
<div class="alert alert-success">
    {{ Session::get('success') }}
</div>
@endif

@if ($errors->any())
<ul class="alert alert-danger">
    @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
    @endforeach
</ul>
@endif

<div class="text-end mb-3">
    <a href="{{ route('pengguna.create') }}" class="btn btn-secondary">Tambah Pengguna</a>
</div>
<table class="table table-striped table-bordered table-hover">
    <thead>
        <tr>
            <td>No</td>
            <td>Nama</td>
            <td>Email</td>
            <td>Role</td>
            <td class="text-center">Aksi</td>
        </tr>
    </thead>
    <tbody>
        @php
            $no = 1;
        @endphp
        @foreach ($pengguna as $item)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $item->name }}</td>
                <td>{{ $item->email }}</td>
                <td>{{ $item->role }}</td>
                <td class="d-flex justify-content-center">
                    <a href="{{ route('pengguna.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#modal-user-{{ $item->id }}">Hapus</button>

                    <div class="modal fade" id="modal-user-{{ $item->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Konfirmasi Hapus</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Yakin ingin menghapus data ini?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <form action="{{ route('pengguna.destroy', $item->id) }}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Hapus</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
@endsection
@extends('layouts.template')

@section('content')
    @if (Session::get('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
    </div>
    @endif

    @if (Session::get('deleted'))
    <div class="alert alert-warning">
        {{ Session::get('deleted') }}
    </div>
    @endif

    @if ($errors->any())
    <ul class="alert alert-danger">
        @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
        @endforeach
    </ul>
    @endif

    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <td>No</td>
                <td>Nama</td>
                <td>Tipe</td>
                <td>Harga</td>
                <td>Stok</td>
                <td class="text-center">Aksi</td>
            </tr>
        </thead>
        <tbody>
            @php
                $no = 1;
            @endphp
            @foreach ($medicine as $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->type }}</td>
                    <td>{{ $item->price }}</td>
                    <td>{{ $item->stock }}</td>
                    <td class="d-flex justify-content-center">
                        <a href="{{ route('medicine.edit', $item->id) }}" class="btn btn-primary me-3">Edit</a>
                        <form action="{{ route('medicine.destroy', $item->id) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
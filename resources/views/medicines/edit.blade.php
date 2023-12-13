@extends('layouts.template')

@section('content')
    <form action="{{ route('medicine.update', $medicine->id) }}" method="post" class="card p-5">
        @csrf
        @method('patch')

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

        <div class="mb-3 row">
            <label for="name" class="col-sm-2 col-form-label">Nama Obat :</label>
            <div class="col-sm-10">
                <input type="text" name="name" id="name" class="form-control" value="{{ $medicine->name }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="type" class="col-sm-2 col-form-label">Jenis Obat :</label>
            <div class="col-sm-10">
                <select name="type" id="type" class="form-select">
                    <option selected disabled hidden>Pilih</option>
                    <option value="tablet" {{ $medicine->type == 'tablet' ? 'selected' : '' }}>tablet</option>
                    <option value="sirup" {{ $medicine->type == 'sirup' ? 'selected' : '' }}>sirup</option>
                    <option value="kapsul" {{ $medicine->type == 'kapsul' ? 'selected' : '' }}>kapsul</option>
                </select>
            </div>
        </div>
        <div class="mb-3 row">
            <label for="price" class="col-sm-2 col-form-label">Harga Obat :</label>
            <div class="col-sm-10">
                <input type="number" name="price" id="price" class="form-control" value="{{ $medicine->price }}">
            </div>
        </div>
        <div class="mb-3 row">
            <label for="stock" class="col-sm-2 col-form-label">Stok Tersedia :</label>
            <div class="col-sm-10">
                <input type="number" name="stock" id="stock" class="form-control" value="{{ $medicine->stock }}">
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3">Ubah Data</button>
    </form>
@endsection
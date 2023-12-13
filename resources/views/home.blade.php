@extends('layouts.template')

@section('content')
<div class="Jumbotron py-4 px-5">
    <h1 class="display-4">
        selamat datang! {{Auth::user()->name}}!
    </h1>
    <p>Aplikasi ini digunakan oleh pegawai administrato APOTEK. Digunakan untuk mengelola data obat, penyetokan juga pembelian (kasir).</p>
</div>
@endsection


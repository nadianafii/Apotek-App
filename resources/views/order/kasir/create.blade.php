@extends('layouts.template')

@section('content')
<div class="container mt-3">
    <form action="{{ route('kasir.order.store') }}" class="card m-auto p-5" method="POST">
        @csrf
        {{-- Validasi error message --}}
        @if ($errors->any())
        <ul class="alert alert-danger p-3">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
      @endif
      @if(Session::get('failed'))
      <div class="alert alert-danger">{{ Session::get('failed') }}</div>
      @endif
       <p>Penanggung Jawab : <b>{{ Auth::user()->name }}</b></p>
       <div class="mb-3 row">
        <label for="name_customer" class="col-sm-2 col-form-label">Nama Pembeli</label>
        <div class="col-sm-10">
        <input type="text" class="form-control" id="name_customer" name="name_customer">
      </div>
    </div>

    <div class="mb-3 row">
        <label for="medicines" class="col-sm-2 col-form-label">Obat</label>
        <div class="col-sm-10">
            {{-- name dibuat array karena nantinya data obat (medicines) akan berbentuk array /data bisa lebi dari satu --}}
       <select name="medicines[]" id="medicines" class="form=select">
        <option selected hidden disabled>Pesanan 1</option>
        @foreach ($medicines as $item)
        <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>
        @endforeach
       </select>
       {{-- div pembungkusan untuk tambahan select yg akan muncul --}}
       <div id="wrap-medicines"></div>
       <br>
       <p style="cursor: pointer" class="text-primary" id="add-select">+ tambah obat</p>
      </div>
    </div>
    <button type="submit" class="btn btn-block btn-lg btn-primary">Konfirmasi Pembelian</button>
    </form>
</div>
@endsection

@push('script')
<!-- Pastikan jQuery sudah dimuat sebelum menggunakan kode ini -->
<script>
    // definisikan no sebagai 2
    let no = 2;
    //ketika tag dengan id add-select di klik, jalankan fungsi berikut
    $("#add-select").on("click", function(){
        //tag HTML yang akan ditambahkan/dimunculkan
        let el = `<br><select name="medicines[]" id="medicines" class="form-select">
                     <option selected hidden disabled>Pesanan ${no}</option>;
                   @foreach ($medicines as $item)
             <option value="{{ $item['id'] }}">{{ $item['name'] }}</option>;
        @endforeach
        </select>`;

        $("#wrap-medicines").append(el);

        no++;
    });
</script>

@endpush

    
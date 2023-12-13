@if (Auth::user()->role == "admin")
   <li>
    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
    aria-expanded="false">
Obat</a>
           <ul  class="dropdown-menu">
            <li><a class="dropdown-item" href="{{ route ('medicine.home') }}">Data Obat</a></li>
            <li><a class="dropdown-item" href="{{ route ('medicine.create') }}">Tambah</a></li>
            <li><a class="dropdown-item" href="{{ route ('medicine.stock') }}">Stock</a></li>
            <li><a class="dropdown-item" href="{{ route ('medicine.stock') }}">Sk</a></li>
                        <li><a class="dropdown-item" href="{{ route ('medicine.stock') }}">Stock</a></li>
           </ul>
   </li>
   <li class="nav-item">
    <a class="nav-link" aria-current="page" href="{{ route('order.data') }}">Pembelian</a>
   </li>
   <li class="nav-item">
    <a class="nav-link" aria-currenr="page" href="{{ route('order.data') }}">Pembelian</a>
   </li>
   <li class="nav-item">
    <a class="nav-link" aria-current="page" href="{{route ('user.index') }}">Kelola Akun</a>
   </li>
@else
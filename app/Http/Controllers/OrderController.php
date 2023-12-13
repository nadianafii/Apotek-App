<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Exports\OrderExport;

use PDF;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function data()
    {
        // with() mengambil function relasi PK ke FK atau FK ke PK dari model
        // isi di petik disamakan dengan nama function modelnya
        $orders = Order::with('pengguna')->simplePaginate(5);
        return view('order.admin.index', compact('orders'));
    }

    public function index()
    {
        $orders = Order::simplePaginate(10);
        return view("order.kasir.index", compact("orders"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view("order.kasir.create", compact('medicines'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_customer' => 'required',
            'medicines' => 'required',
        ]);
        //mencari jumlah item yang samapada array, strukturnya :
        // [ "item" => "jumlah"  ]
        $arrayDistinct = array_count_values($request->medicines);
        $arrayAssocMedicines= [];
        foreach ($arrayDistinct as $id => $count){
            //mencari data obat berdasakan id (obat yang dipilih)
            $medicine = Medicine::where('id', $id)->first();
           //ambil bagian column price dr hasil pencarian lalu kalikan dengan jumlah item duplikat semhingga akan menghasilkan total harga dr pembelian obat tsb
           $subPrice = $medicine['price'] * $count;
           //struktur value column medicines menjadi multidimensi dengan dimensi kedua berbentuk array assoc dengan key "id", name_medicine", "qty,price"
           $arrayItem = [
            "id" => $id,
            "name_medicine" => $medicine['name'],
            "qty" => $count,
            "price" => $medicine['price'],
            "sub_price" => $subPrice,
           ];
           //masukkan struktur array tersebut ke array kosong yg disediakan sebelumnya
           array_push($arrayAssocMedicines,$arrayItem);
        }
        $totalPrice = 0 ; 
        //looping format array medicines baru
        foreach ($arrayAssocMedicines as $item){
            $totalPrice += (int)$item['sub_price'];
        }
        //harga beli ditambah 10%ppn 
        $priceWithPpn = $totalPrice + ($totalPrice * 0.01 );
        //tambah data ke database
        $proses = Order::create([
            // data user_id diambil dari id akun kasir yg sedang login
            'user_id' => Auth::user()->id,
            'medicines' => $arrayAssocMedicines,
            'name_customer' => $request->name_customer,
            'total_price' => $priceWithPpn,
        ]);

        if ($proses){
            //jika proses tambh data berhasil, ambil data order yang dibuat oleh kasir yg sedang login (where), dengan tanggal paling terbaru (orderBy),ambil hanya satu data (first)
            $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'DESC')->first();
            //kirim data order yang diambil, bagian column id sebagai paramenter path dari route print
            return redirect()->route('kasir.order.print', $order['id']);
        }else{
            return redirect()->back->with('failed', 'gagal memuat data pembelian. silakan coba lagi kembali dengan data yg sesuai!');
        }
    }

    public function search(Request $request)
    {
        $searchDate = $request->get('search');
        $orders = Order::whereDate('created_at', $searchDate)->simplePaginate(5);
        return view('order.kasir.index', compact('orders'));    
    }
    public function searchAdmin(Request $request)
    {
        $searchDate = $request->get('searchAdmin');
        $orders = Order::whereDate('created_at', $searchDate)->simplePaginate(5);
        return view('order.admin.index', compact('orders'));  
    }
    /**
     * Display the specified resource.
     */
    public function show($id)
    {
    
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }


    public function downloadPDF($id)
    {
        //ambil data yg diperlukan dan berformat array
        $order = Order::find($id)->toArray();
        //mengiirim inisial variable dari data yang akan digunakan pada layout pdf
        view()->share('order', $order);
        //panggil blade yang akan di download
        $pdf = PDF::loadView('order.kasir.download-pdf',$order);
        // ($pdf);
        //kembalikan atau hasilkan bentuk pdf dengan nama file tertentu
        return $pdf->download('recipt.pdf');
    }

    public function exportExcel()
    {
        $file_name = 'data_pembelian'.'.xlsx';

        return Excel::download(new OrderExport, $file_name);
    }

    public function update(Request $request, Order $order)  
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Order $order)
    {
        //
    }
}

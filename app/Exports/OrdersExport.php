<?php

// fugnsinya untuk mendefinisikan file ini lokasiny ada dimana, pemanggilan harus sesuai namespace
namespace App\Exports;

use App\Models\Order;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
// UNTUK MENGGUNAKAN FUNC HEADingd
use Maatwebsite\Excel\Concerns\WithHeadings;
// UNTUK MENGGUNAKAN FUNC map
use Maatwebsite\Excel\Concerns\WithMapping;



class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * @return \Illuminate\Support\Collection
    */
    // proses pengambilan data yang akan di export
    public function collection()
    {
        return Order::with('user')->get();
    }
    //  headers dan map bersifat optional
    // menentukan nama nama column di excelnya
    public function headings(): array
    {
        return [
            "Nama Pembeli", 
            "Pesanan",
            "Total Harga (+ppn)",
            "Kasir",
            "Tanggal"
        ];
    }


    // date dari collection (pengambilan dari db) yang akan dimunculkan ke excel -> sebagai perantara
    // fungsi parameter $item = mengambil data dari database
    public function map($item) : array 
    {
        $pesanan = "";
        foreach ($item['medicines'] as $medicine) {
            // menggunakan concat gabungan karena kemungkinan pembelian obat lebih dari satu
            $pesanan .= "( ". $medicine['name_medicine'] . " : qty " . $medicine['qty'] . " : Rp. " . number_format($medicine['price'], 0, '.', '.') . " ),";
        }
        $totalAfterPPN = $item->total_price + ($item->total_price * 0.1);
        // urutannya harus sama dengan yang headings
        return [
            $item->name_customer,
            $pesanan,
            "Rp. " . number_format($totalAfterPPN, 0, '.', '.'),
            $item['user']['name'] . "( " .  $item['user']['email'] . ")",
            Carbon::parse($item['created_at'])->format("d-m-Y H:i:s")
        ];
    } 
}

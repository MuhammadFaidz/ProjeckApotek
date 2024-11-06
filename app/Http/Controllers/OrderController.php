<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Medicine;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('order.kasir.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $medicines = Medicine::all();
        return view('order.kasir.create', compact('medicines'));
    }

    /** 
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name_costumer' => 'required|max:50',
            'medicines' => 'required',
        ]);

        //jumlah item yg sama pada array
        $arrayDistinct = array_count_values($request->medicines);
        //menyiapkan array kosong untuk menampung format array baru
        $arrayMedicines = [];

        foreach($arrayDistinct as $id => $count) {
            $medicines = Medicine::Where('id', $id,)->first();

            $subPriceMedicines = $medicines['price'] * $count;

            $arrayItem = [
                "id" => $id,
                "name_medicine" => $medicines['name'],
                "qty" => $count,
                "price" => $medicines['price'],
                "sub_price" => $subPriceMedicines,
            ];

            array_push($arrayMedicines, $arrayItem);
        }

        $totalPrice = 0;

        foreach($arrayMedicines as $item) {
            $totalPrice += (int)$item['sub_price'];
        }

        //harga total price di tambah 10%
        $pricePpn = $totalPrice + ($totalPrice * 0.01);

        $proses = order::create([
            'user_id' => Auth::user()->id,
            'medicines' => $arrayMedicines,
            'name_costumer' => $request->name_costumer,
            'total_price' => $pricePpn,
        ]);

        if($proses) {
            $order = order::Where('user_id', Auth::user()->id)->orderby('created_at', 'DESC')->first();

            return redirect()->route('kasir.order.print', $order['id']);
        } else {
            return redirect()->back()->with('failed', 'Gagal membuat data pembelian, Silahkan coba kembali dengan data yang sesuai');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $order = order::find($id);
        return view('order.kasir.print', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
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

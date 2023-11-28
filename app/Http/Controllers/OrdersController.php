<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;

class OrdersController extends Controller{

    public function index(){
        $order = Order::OrderBy("id","DESC")->paginate(10);

        $output = [
            "message" => "order",
            "result" => $order
        ];

        return response()->json($order,200);
    }

    public function store(Request $request){
        $input = $request->all(); //mengambil semua input dari user
        $order = Order::create($input); //membuat order baru

        return response()->json($order,200); //mengembalikan data order baru dalam bentuk json
    }

    public function show($id){
        $order = Order::find($id); //mencari order berdasarkan id

        if(!$order){
            abort(404);
        }

        return response()->json($order,200);
    }

    public function update(Request $request, $id){
        $input = $request->all(); //mengambil semua input dari user
        $order = Order::find($id); //mencari order berdasarkan id

        if(!$order){
            abort(404);
        }

        $order->fill($input); //mengisi order dengan data baru dari input
        $order->save(); //menyimpan order ke database

        return response()->json($order,200); //mengembalikan data order yang baru diupdate dalam bentuk json
    }

    public function destroy($id){
        $order = Order::find($id); //mencari order berdasarkan id

        if(!$order){
            abort(404);
        }

        $order->delete(); //menghapus order

        $message = ["message" => "delete success", "order_id" => $id];

        return response()->json($message,200); //mengembalikan pesan ketika order berhasil dihapus
    }
}
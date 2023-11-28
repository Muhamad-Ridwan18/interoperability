<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\Product;


class ProductsController extends Controller
{
    public function index(Request $request)
    {
        $acceptHeader = $request->header('Accept');
        $product = Product::Where(['id' => Auth::user()->id])->OrderBy("id","ASC")->paginate(10)->toArray();

        $response = [
            "total_count" => $product["total"],
            "limit" => $product["per_page"],
            "pagination" => [
                "next_page" => $product["next_page_url"],
                "current_page" => $product["current_page"]
            ],
            "data" => $product["data"],
        ];

        if ($acceptHeader === "application/json"){
            return response()->json($response,200);
        }else {
            return response('Not Acceptable!', 406);
        }
    }
    
    public function store(Request $request){
        $acceptHeader = $request->header('Accept');
        if ($acceptHeader === 'application/json'){
            $contentTypeHeader = $request->header('Content-Type');

            if ($contentTypeHeader === 'application/json'){
                $input = $request->all();

                $validationRules = [
                    'name' => 'required|min:5',
                    'description' => 'required|min:10',
                    'category_id' => 'required|int',
                    'brand' => 'required|min:3',
                    'price' => 'required|int',
                    'stock' => 'required|int'
                ];

                $validator = Validator::make($input, $validationRules);

                if ($validator->fails()){
                    return response()->json($validator->errors(),400);
                }

                $product = Product::create($input);
                return response()->json($product,200);
            }
            else {
                return response('Not Acceptable!', 406);
            }
        }else {
            return response('Not Acceptable!', 406);
        }
    }

    public function show(Request $request,$id){
        $acceptHeader = $request->header("Accept");
        if ($acceptHeader === "application/json"){
            $product = Product::find($id);

                if(!$product){
                    abort(404);
                }

                return response()->json($product,200);
            }else{
                return response('Not Acceptable!', 406); 
            }
    }

    public function update(Request $request, $id){
        $acceptHeader = $request->header("Accept");
        if ($acceptHeader==="application/json"){
            $contentTypeHeader = $request->header("Content-Type");
            if ($contentTypeHeader === "application/json"){
                $input = $request->all(); //mengambil semua input dari user
                $product = Product::find($id); //mencari product berdasarkan id
    
                if(!$product){
                    abort(404);
                }
    
                $validationRules = [
                    'name' => 'required|min:5',
                    'description' => 'required|min:10',
                    'category_id' => 'required|int',
                    'brand' => 'required|min:3',
                    'price' => 'required|int',
                    'stock' => 'required|int'
                ];
                $validator = Validator::make($request->all(), $validationRules); //membuat validasi inputan user
    
                if ($validator->fails()){
                    return response()->json($validator->errors(),400);
                }
                $product-> fill($input); //mengisi product dengan data baru dari input
                $product->save(); //menyimpan product ke database
            }
            else {
                return response('Not Acceptable!', 406);
            }
        }else {
            return response('Not Acceptable!', 406);
        }
    }

    public function destroy(Request $request,$id){
        $acceptHeader = $request->header("Accept");
        if ($acceptHeader==="application/json"){
            $product = Product::find($id); //mencari product berdasarkan id
    
            if(!$product){
                abort(404);
            }
    
            $product->delete(); //menghapus product
    
            $message = ["message" => "delete success", "id" => $id];
    
            return response()->json($message,200); //mengembalikan pesan ketika product berhasil dihapus
        }
    }
}
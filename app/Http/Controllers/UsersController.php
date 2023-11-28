<?php

namespace App\Http\Controllers;

Use App\Models\User;
use Illuminate\Http\Request;


class UsersController extends Controller
{
    public function index()
    {
        $users = User::OrderBy("id","DESC")->paginate(10);

        $output = [
            "message" => "users",
            "result" => $users
        ];

        return response()->json($users,200);
    }

    
    public function store(Request $request){
        $input = $request->all(); //mengambil semua input dari user
        $user = User::create($input); //membuat user baru

        return response()->json($user,200); //mengembalikan data user baru dalam bentuk json
    }

    public function show($id){
        $user = User::find($id); //mencari user berdasarkan id

        if(!$user){
            abort(404);
        }

        return response()->json($user,200);
    }

    public function update(Request $request, $id){
        $input = $request->all(); //mengambil semua input dari user
        $user = User::find($id); //mencari user berdasarkan id

        if(!$user){
            abort(404);
        }

        $user->fill($input); //mengisi user dengan data baru dari input
        $user->save(); //menyimpan user ke database

        return response()->json($user,200); //mengembalikan data user yang baru diupdate dalam bentuk json
    }

    public function destroy($id){
        $user = User::find($id); //mencari user berdasarkan id

        if(!$user){
            abort(404);
        }

        $user->delete(); //menghapus user

        $message = ["message" => "delete success", "id" => $id];

        return response()->json($message,200); //mengembalikan pesan ketika user berhasil dihapus
    }

}
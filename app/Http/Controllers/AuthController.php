<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\User;

class AuthController extends Controller
{

    public function register(Request $request)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'name' => 'required',
            'email' => 'required',
            'gender' => 'required|in:male,female',
            'password' => 'required',
            'role' => 'required|in:reader,editor,admin',
            'phone_number' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Buat user baru
        $user = new User;
        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->gender = $request->input('gender');
        $user->password = app('hash')->make($request->input('password'));
        $user->role = $request->input('role');
        $user->phone_number = $request->input('phone_number');

        // print_r($user);
        // die();

        $user->save();


        return response()->json($user, 200);
    }

    public function login(Request $request)
    {
        $input = $request->all();

        // Validasi input
        $validator = Validator::make($input, [
            'email' => 'required',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 400);
        }

        // Cek login
        $credentials = $request->only(['email', 'password']);

        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        return response()->json([
            'token' => $token,
            'token_type' => 'bearer',
            'expires_in' => Auth::factory()->getTTL() *3600,
        ], 200);
    }
}
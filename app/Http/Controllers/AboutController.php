<?php

namespace App\Http\Controllers;

use Illuminate\Http\Response;

class AboutController extends Controller
{
    public function about()
    {
        return response()->json([
            'message' => 'This is the about page of this web.',
            'version' => '1.0.0',
            'author' => 'Rangga Eka Kusuma Dani',
            'email' => 'ranggaeka@example.com'
        ], Response::HTTP_OK);    
    }
}
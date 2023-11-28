<?php

namespace App\Http\Controllers;

use App\Models\Category;

class CategoriesController extends Controller{

    public function index(){
        $categories = Category::OrderBy("id","DESC")->paginate(10);

        $output = [
            "message" => "categories",
            "result" => $categories
        ];

        return response()->json($categories,200);
    }
}
<?php

namespace App\Http\Controllers;

use App\Models\Tag;

class TagsController extends Controller{

    public function index(){
        $tags = Tag::OrderBy("id","DESC")->paginate(10);

        $output = [
            "message" => "tags",
            "result" => $tags
        ];

        return response()->json($tags,200);
    }
}
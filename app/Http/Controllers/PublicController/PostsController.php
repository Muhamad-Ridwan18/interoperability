<?php 

namespace App\Http\Controllers\PublicController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostsController extends Controller{
    public function index(){
        $posts = Post::OrderBy("id", "ASC")->paginate(10)->toArray();
        $response = [
            "total_count" => $posts["total"],
            "limit" => $posts["per_page"],
            "pagination" => [
                "next_page" => $posts["next_page_url"],
                "current_page" => $posts["current_page"]
            ],
            "data" => $posts["data"],
        ];

        return response()->json($response, 200);
    }

    public function show($id){
        $post = Post::find($id);
        return response()->json([
            'status' => 'success',
            'data' => $post
        ]);
    }

    public function image($imageName)
    {
        $imagePath = storage_path('uploads/image_post') . '/' . $imageName . '.jpg' ?? storage_path('uploads/image_post') . '/' . $imageName . '.jpg' ?? storage_path('uploads/image_post') . '/' . $imageName . '.jpeg';
        
        if (!file_exists($imagePath)) {
            return response()->json(['message' => 'Image not found'], 404);
        } 
        $file = file_get_contents($imagePath);
        
        return response($file, 200)->header('Content-Type', 'image/png' ?? 'image/jpeg' ?? 'image/jpg');
    }

    public function video($videoName)  
    {
        $videoPath = storage_path('uploads/video_post') . '/' . $videoName . '.mp4' ?? storage_path('uploads/video_post') . '/' . $videoName . '.mov' ?? storage_path('uploads/video_post') . '/' . $videoName . '.ogg';
        if (!file_exists($videoPath)) {
            return response()->json(['message' => 'Video not found'], 404);
        } 
        $file = file_get_contents($videoPath);
        
        return response($file, 200)->header('Content-Type', 'video/mp4' ?? 'video/mov' ?? 'video/ogg');
    }
}
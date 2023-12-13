<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class PostsController extends Controller
{

    public function index(Request $request)
    {
        $acceptHeader = $request->header("Accept");

        // Authorization
        if (Gate::denies('read-post')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to read post'
            ], 403);
        }
        if (Auth::user()->role === 'admin'){
            $posts = Post::OrderBy("id", "ASC")->paginate(10)->toArray();
        }else{
            $posts = Post::Where(['user_id' => Auth::user()->id])->OrderBy("id", "ASC")->paginate(10)->toArray();
        }
        // End Authorization

            $response = [
                "total_count" => $posts["total"],
                "limit" => $posts["per_page"],
                "pagination" => [
                    "next_page" => $posts["next_page_url"],
                    "current_page" => $posts["current_page"]
                ],
                "data" => $posts["data"],
            ];

        if ($acceptHeader === "application/json" || $acceptHeader === "application/xml") {
            if ($acceptHeader === "application/json") {
                // JSON
                return response()->json($response, 200);
            } else {
                // XML
                $xml = new \SimpleXMLElement('<posts/>');
                foreach ($posts->items('data') as $item) {
                    $xmlItem = $xml->addChild('post');
                    $xmlItem->addChild('id', $item->id);
                    $xmlItem->addChild('title', $item->title);
                    $xmlItem->addChild('author', $item->author);
                    $xmlItem->addChild('category', $item->category);
                    $xmlItem->addChild('status', $item->status);
                    $xmlItem->addChild('content', $item->content);
                    $xmlItem->addChild('user_id', $item->user_id);
                    $xmlItem->addChild('created_at', $item->created_at);
                    $xmlItem->addChild('updated_at', $item->updated_at);
                }
                return $xml->asXML();
            }
        } else {
            return response('Not Acceptable!', 406);
        }
    }

    public function store(Request $request)
    {
        // Pengecekan izin menggunakan Gate
        if (Gate::denies('create-post')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to create post'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Jika ingin memerlukan gambar, tambahkan required
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480', // Jika ingin memerlukan video, tambahkan required
        ]);
    
        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // Mengambil data dari request
        $data = $request->only(['title', 'author', 'category', 'status', 'content', 'user_id']);

        // Upload dan simpan gambar jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'post_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('uploads/image_post'), $imageName);
            $data['image'] = $imageName;
        }
        

        // Upload dan simpan video jika ada
        if ($request->hasFile('video')) {
            $videoPath = $request->file('video');
            $videoName = 'post_' . time() . '.' . $videoPath->getClientOriginalExtension();
            $videoPath->move(storage_path('uploads/video_post'), $videoName);
            $data['video'] = $videoName;
        }

        // Buat dan simpan post
        $post = Post::create($data);

        // Redirect atau response sesuai kebutuhan aplikasi
        return response()->json([
            'success' => true,
            'message' => 'Post successfully created',
            'data' => $post
        ], 201);
    }

    public function show(Request $request,$id)
    {
        $acceptHeader = $request->header("Accept");

        
        if ($acceptHeader === "application/json"){
            $post = Post::find($id); //mencari post berdasarkan id
            
            if (!$post) {
                abort(404);
            }
            
            // Authorization
            if (Gate::denies('read-detail-post', $post)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to read detail post'
                ], 403);
            }
            // End Authorization

            return response()->json($post, 200);
        }elseif ($acceptHeader === "application/xml"){
            $post = Post::find($id); //mencari post berdasarkan id

            if (!$post) {
                abort(404);
            }

            $xml = new \SimpleXMLElement('<posts/>');
            $xmlItem = $xml->addChild('post');
            $xmlItem->addChild('id', $post->id);
            $xmlItem->addChild('title', $post->title);
            $xmlItem->addChild('author', $post->author);
            $xmlItem->addChild('category', $post->category);
            $xmlItem->addChild('status', $post->status);
            $xmlItem->addChild('content', $post->content);
            $xmlItem->addChild('user_id', $post->user_id);
            $xmlItem->addChild('created_at', $post->created_at);
            $xmlItem->addChild('updated_at', $post->updated_at);

            return $xml->asXML();
        }else{
            return response('Not Acceptable!', 406);
        }
    }

    public function update(Request $request, $id)
    {
        // Pengecekan izin menggunakan Gate
        if (Gate::denies('update-post')) {
            return response()->json([
                'success' => false,
                'message' => 'You do not have permission to update post'
            ], 403);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'status' => 'required|string|max:255',
            'content' => 'required|string',
            'user_id' => 'required|integer',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'video' => 'nullable|mimes:mp4,mov,ogg,qt|max:20480',
        ]);

        // Cek jika validasi gagal
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()
            ], 422);
        }

        // Cari post berdasarkan ID
        $post = Post::find($id);

        // Jika post tidak ditemukan
        if (!$post) {
            return response()->json([
                'success' => false,
                'message' => 'Post not found'
            ], 404);
        }

        // Menghapus foto lama jika ada
        if ($post->image) {
            // Hapus foto lama dari penyimpanan
            $oldImagePath = storage_path("uploads/image_post/{$post->image}");
            if (file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }
        }

        // Mengambil data dari request
        $data = $request->only(['title', 'author', 'category', 'status', 'content', 'user_id']);

        // Upload dan simpan foto baru jika ada
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'post_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('uploads/image_post'), $imageName);
            $data['image'] = $imageName;
        }

        // Upload dan simpan video baru jika ada
        if ($request->hasFile('video')) {
            $video = $request->file('video');
            $videoName = 'post_' . time() . '.' . $video->getClientOriginalExtension();
            $video->move(storage_path('uploads/video_post'), $videoName);
            $data['video'] = $videoName;
        }

        // Update post dengan data baru
        $post->update($data);

        // Redirect atau response sesuai kebutuhan aplikasi
        return response()->json([
            'success' => true,
            'message' => 'Post successfully updated'
        ]);
    }


    public function destroy(Request $request,$id)
    {
        $acceptHeader = $request->header("Accept");

        
        if ($acceptHeader==="application/json" ){
            // JSON
            $post = Post::find($id); //mencari post berdasarkan id
            
            if (!$post) {
                return response('Post not found', 404);
            }
            
            // Authorization
            if (Gate::denies('delete-post', $post)) {
                return response()->json([
                    'success' => false,
                    'message' => 'You do not have permission to delete post'
                ], 403);
            }
            // End Authorization

            $post->delete(); //menghapus post

            $message = ["message" => "delete success", "id" => $id];

            return response()->json($message, 200); //mengembalikan pesan ketika post berhasil dihapus
        }elseif($acceptHeader==="application/xml"){
            // XML
            $post = Post::find($id); //mencari post berdasarkan id

            if (!$post) {
                return response('Post not found', 404);
            }

            if($post->delete()){
                $xml = new \SimpleXMLElement('<message/>');
                $xml->addChild('message', 'deleted successfully');
                $xml->addChild('id', $id);
 
                return $xml->asXML();
            }else{
                return response('Internal Server Error', 500);
            }
        }else{
            return response('Not Acceptable!', 406);
        }   
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

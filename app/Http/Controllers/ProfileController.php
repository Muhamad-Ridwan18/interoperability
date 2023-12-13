<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class ProfileController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    public function index() : Returntype {
        
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $this->validate($request, [
            'first_name' => 'required',
            'last_name' => 'required',
            'summary' => 'required',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $imageName = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = 'profile_' . time() . '.' . $image->getClientOriginalExtension();
            $image->move(storage_path('uploads/profiles'), $imageName);

            if ($user->profile && $user->profile->image) {
                $oldImagePath = storage_path('uploads/profiles') . '/' . $user->profile->image;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }
        }

        $profileData = [
            'user_id' => $user->id,
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'summary' => $request->input('summary'),
        ];

        if ($imageName) {
            $profileData['image'] = $imageName;
        }

        $profile = Profile::updateOrCreate(['user_id' => $user->id], $profileData);

        return response()->json(['message' => 'Profile created/updated successfully', 'data' => $profile], 201);
    }


    public function show($id) {
        $profile = Profile::where('id', $id)->first();

        if (!$profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }
    

        return response()->json(['data' => $profile]);
    }

    public function image($imageName)
    {
        $imagePath = storage_path('uploads/profiles') . '/' . $imageName . '.png' ?? storage_path('uploads/profiles') . '/' . $imageName . '.jpg' ?? storage_path('uploads/profiles') . '/' . $imageName . '.jpeg';
        
        if (!file_exists($imagePath)) {
            return response()->json(['message' => 'Image not found'], 404);
        } 
        $file = file_get_contents($imagePath);
        
        return response($file, 200)->header('Content-Type', 'image/png' ?? 'image/jpeg' ?? 'image/jpg');
    }

}

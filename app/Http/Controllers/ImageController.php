<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Facades\Image;
use App\User;

class ImageController extends Controller
{
    public function store(User $user){

        $post = $user->posts()->create([
            'body' => request()->caption,
            'posted_by_id' => request()->posted_by_id
        ]);


        foreach(request()->images as $image){
            $imagePath = $image->store('images','public');

            $post->images()->create([
                'image' => $imagePath
            ]);
        }

        return response()->json($post);
    }
}

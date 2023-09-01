<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    //

    public function index(Request   $request){
        // dd($request->all());

        if ($request->has('search')){
            $posts = Post::with('category', 'user', 'tags')->where('title', 'LIKE', '%' . $request->search . '%')->paginate(20);
        } else {
            $posts = Post::with('category', 'user', 'tags')->paginate(20);
        }



        return response()->json(
            [
                'success' => true,
                'results' => $posts,
            ]
        );
    }

    public function show(string $slug){
        $post = Post::with('category', 'user', 'tags')->findOrFail($slug);

        return response()->json([
            'success' => true,
            'results' => $post
        ]);
    }
}

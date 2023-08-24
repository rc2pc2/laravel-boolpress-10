<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;


class PostController extends Controller
{
    /**
     * Display a listing of the Post resource.
     */
    public function index()
    {
        $posts = Post::paginate(15);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new Post resource.
     */
    public function create()
    {
        return view('admin.posts.create');
    }

    /**
     * Store a newly created Post resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());

        $data = $request->validate([
            'title' => ['required', 'unique:posts','min:3', 'max:255'],
            'image' => ['image'],
            'content' => ['required', 'min:10'],
        ]);

        if ($request->hasFile('image')){
            $img_path = Storage::put('uploads/posts', $request['image']);
            $data['image'] = $img_path;
        }

        $data["slug"] = Str::of($data['title'])->slug('-');
        $newPost = Post::create($data);

        $newPost->slug = Str::of("$newPost->id " . $data['title'])->slug('-');
        $newPost->save();

        return redirect()->route('admin.posts.show', $newPost);
    }

    /**
     * Display the specified Post resource.
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified Post resource.
     */
    public function edit(Post $post)
    {
        return view('admin.posts.edit', compact('post'));
    }

    /**
     * Update the specified Post resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required', 'min:3', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'image' => ['image'],
            'content' => ['required', 'min:10'],
        ]);

        if ($request->hasFile('image')){
            Storage::delete($post->image);
            $img_path = Storage::put('uploads/posts', $request['image']);
            $data['image'] = $img_path;
        }

        $data['slug'] = Str::of("$post->id " . $data['title'])->slug('-');

        $post->update($data);

        return redirect()->route('admin.posts.show', compact('post'));
    }

    /**
     * Moves the specified Post resource from storage to the list of deleted Post resources.
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return redirect()->route('admin.posts.index');
    }

    /**
     * Display  a listing of soft-removed Post resources.
     *
     * @return void
     */
    public function deletedIndex(){
        $posts = Post::onlyTrashed()->paginate(10);

        return view('admin.posts.deleted', compact('posts'));
    }

    /**
     * Restores a Post resource from the list of deleted Post resources.
     *
     * @param string $slug
     * @return void
     */
    public function restore(string $slug){
        $post = Post::onlyTrashed()->findOrFail($slug);
        $post->restore();

        return redirect()->route('admin.posts.show', $post);
    }

    /**
     * Permanently removes the single Post resource from the database.
     *
     * @param string $slug
     * @return void
     */
    public function obliterate(string $slug)
    {
        $post = Post::onlyTrashed()->findOrFail($slug);
        Storage::delete($post->image);
        $post->forceDelete();

        return redirect()->route('admin.posts.index');
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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
        // dd(Auth::user()->id);
        $posts = Post::where('user_id',Auth::user()->id)->paginate(10);
        // dd($posts);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new Post resource.
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories', 'tags'));
    }

    /**
     * Store a newly created Post resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => ['required', 'unique:posts','min:3', 'max:255'],
            'image' => ['required', 'image'],
            'content' => ['required', 'min:10'],
            'tags' => ['exists:tags,id'],
            'category_id' => ['required', 'exists:categories,id'],
        ]);

        if ($request->hasFile('image')){
            $img_path = Storage::put('uploads/posts', $request['image']);
            $data['image'] = $img_path;
        }

        $data["slug"] = Str::of($data['title'])->slug('-');
        $data['user_id'] = Auth::user()->id;
        $newPost = Post::create($data);

        $newPost->slug = Str::of("$newPost->id " . $data['title'])->slug('-');
        $newPost->save();

        if ($request->has('tags')){
            $newPost->tags()->sync( $request->tags);
        }

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
        $tags = Tag::all();
        $categories = Category::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified Post resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $data = $request->validate([
            'title' => ['required', 'min:3', 'max:255', Rule::unique('posts')->ignore($post->id)],
            'image' => ['image', 'max:512'],
            'content' => ['required', 'min:10'],
            'tags' => ['exists:tags,id'],
            'category_id' => ['required', 'exists:categories,id']
        ]);

        if ($request->hasFile('image')){
            Storage::delete($post->image);
            $img_path = Storage::put('uploads/posts', $request['image']);
            $data['image'] = $img_path;
        }

        $data['slug'] = Str::of("$post->id " . $data['title'])->slug('-');

        $post->update($data);

        if ($request->has('tags')){
            $post->tags()->sync( $request->tags);
        }

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
        $post->tags()->detach();
        $post->forceDelete();

        return redirect()->route('admin.posts.index');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    //--login system
    public function __construct()
    {
        $this->middleware(['auth','verified'])->except(['allposts']);
    }

    public function index()
    {
        $posts = Post::with('user')->latest()->paginate(10);
        return view('posts.index', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'languages'      => 'required|string',
            'image'        => 'nullable|file|mimes:pdf|max:5120', // Changed 'image' to 'file', restricted to pdf, raised max size to 5MB
            'type'         => 'nullable|string|max:50',
            'is_published' => 'boolean',
        ]);

        // Auto-generate initial slug from title
        $slug = Str::slug($request->title);
        // Check if the slug already exists, loop until a unique one is found
        $count = Post::where('slug', 'LIKE', "{$slug}%")->count();
        if ($count > 0) {
            $slug = "{$slug}-" . ($count + 1);
        }
        $validated['slug'] = $slug;

        $validated['user_id'] = auth()->id() ?? 1;

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $validated['is_published'] = $request->has('is_published');

        Post::create($validated);

        return redirect()->route('posts.index')->with('success', 'Post created successfully.');
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    public function edit(Post $post)
    {
        return view('posts.edit', compact('post'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title'        => 'required|string|max:255',
            'languages'      => 'required|string',
            'image'        => 'nullable|file|mimes:pdf|max:5120', // Changed to file and mimes:pdf
            'type'         => 'nullable|string|max:50',
            'is_published' => 'boolean',
        ]);

         // Auto-generate initial slug from title
        // $slug = Str::slug($request->title); 
        // $count = Post::where('slug', 'LIKE', "{$slug}%")->count();
        // if ($count > 0) {
        //     $slug = "{$slug}-" . ($count + 1);
        // }
        // $validated['slug'] = $slug;


        $validated['is_published'] = $request->has('is_published');

        if ($request->hasFile('image')) {
            if ($post->image) {
                Storage::disk('public')->delete($post->image);
            }
            $validated['image'] = $request->file('image')->store('posts', 'public');
        }

        $post->update($validated);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        if ($post->image) {
            Storage::disk('public')->delete($post->image);
        }

        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }

    public function allposts()
    {         
        $posts = Post::where('is_published',1)->get();
        return response()->json(['data' => $posts]);
    }
}
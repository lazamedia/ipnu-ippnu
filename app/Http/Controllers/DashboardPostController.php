<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;


class DashboardPostController extends Controller
{

    // public function __construct()
    // {
    //     // Terapkan middleware pada metode create, store, edit, update, dan destroy
    //     $this->middleware('role:admin,super_admin')->only(['create', 'store', 'edit', 'update', 'destroy']);
    //     $this->middleware('role:admin')->only(['destroy']);
    // }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        
        return view('dashboard.posts.index', [
            // $post = Post::paginate(10),
            'post' => Post::where('user_id', auth()->user()->id)->paginate(10)
        ]);
    } 

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.posts.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'slug' => 'required',
            'name' => 'required',
            'category_id' => 'required',
            'body' => 'required'
            
        ]);

        if($request->file('image')) {
            $validatedData['image'] = $request->file('image')->store('post', 'public');
        }

        
        $validatedData ['user_id'] = auth()->user()->id;
        $validatedData ['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::create($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Berhasil Menambahkan Postingan !');

    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('dashboard.posts.show', [
            'post' => $post
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        
        return view('dashboard.posts.edit', [
            'post' => $post,
            'categories' => Category::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        $rules = ([
            'title' => 'required|max:255',
            'name' => 'required',
            'category_id' => 'required',
            'image' => 'image|file|max:4000',
            'body' => 'required'
        ]);
        

        if($request->slug != $post->slug) {
            $rules['slug'] = 'required|unique:posts';
        }

        $validatedData = $request->validate($rules);

        if($request->file('image')) {
            if($request->oldImage) {
                Storage::delete($request->oldImage);
            }
            $validatedData['image'] = $request->file('image')->store('post', 'public');
        }

        $validatedData ['user_id'] = auth()->user()->id;
        $validatedData ['excerpt'] = Str::limit(strip_tags($request->body), 200);

        Post::where('id', $post->id)
        ->update($validatedData);

        return redirect('/dashboard/posts')->with('success', 'Berhasil Update Postingan !');

    }


    public function destroy($id)
    {
        $posts = Post::findOrFail($id);
        if($posts->image) {
            Storage::delete($posts->image);
        }
        $posts->delete();

        return redirect('/dashboard/posts')->with('success', 'Berhasil Menghapus Postingan !');
    }
    public function checkSlug(Request $request) {
        $slug = SlugService::createSlug(Post::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }


    public function bulkDelete(Request $request)
    {
    // Validasi bahwa request memiliki array ID
    $request->validate([
        'ids' => 'required|array',
        'ids.*' => 'exists:posts,id',
    ]);

    // Ambil daftar pengurus berdasarkan ID yang dikirim
    $postsList = Post::whereIn('id', $request->ids)->get();

    foreach ($postsList as $posts) {

        // Hapus pengurus dari database
        $posts->delete();
    }

    return response()->json(['success' => true, 'message' => 'Data pengurus berhasil dihapus.']);
    }

}

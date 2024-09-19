<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\User;

class PostControler extends Controller
{
    public function index()
    {
        
        $title = '';
        if(request('category')){
            $category = Category::firstWhere('slug', request('category'));
            if($category) {
                $title = ' ' . $category->name;
            } else {
                $title = 'Kategori tidak ditemukan';
            }
        }
        
        if(request('author')){
            $author = User::firstWhere('username', request('author'));
            if($author) {
                $title = ' by ' . $author->name;
            } else {
                $title = 'Penulis tidak ditemukan';
            }
        }
        
        return view('posts', [
            "title" => "Semua Postingan " .$title,
            "active" => 'posts',
            // "posts" => Post::all()
            
        "posts" => Post::with(['author', 'category'])->latest()->filter(request(['search', 'category', 'author']))->paginate(7)->withQueryString()
        ]);
    }
    // with(['author', 'category'])->
    public function show(Post $post)
    {
        $latestPosts = Post::latest()->take(5)->get();
        $categories = Category::all();

        return view('post', [
            "title" => "Single Post",
            "active" => 'posts',
            "post" => $post,
            "latestPosts" => $latestPosts,
            "categories" => $categories
        ]);
    }
}

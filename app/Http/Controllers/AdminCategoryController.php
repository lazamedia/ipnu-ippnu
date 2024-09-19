<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AdminCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('dashboard.categories.index', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('dashboard.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'slug' => 'required|unique:categories',
            'image' => 'image|file|max:4000'
        ]);

        if ($request->file('image')) {
            // Simpan gambar ke folder public/storage/category
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }

        Category::create($validatedData);

        return redirect('/dashboard/categories')->with('success', 'Berhasil Menambahkan Kategori!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        return response()->json($category);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('dashboard.categories.edit', [
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $rules = [
            'name' => 'required',
            'image' => 'image|file|max:4000'
        ];

        if ($request->slug != $category->slug) {
            $rules['slug'] = 'required|unique:categories';
        }

        $validatedData = $request->validate($rules);

        if ($request->file('image')) {
            // Hapus gambar lama jika ada
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }

            // Simpan gambar baru
            $validatedData['image'] = $request->file('image')->store('category', 'public');
        }

        $category->update($validatedData);

        return redirect('/dashboard/categories')->with('success', 'Berhasil Update Kategori!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        if ($category->image) {
            // Hapus gambar terkait kategori dari storage
            Storage::delete('public/' . $category->image);
        }
        $category->delete();

        return redirect('/dashboard/categories')->with('success', 'Berhasil Menghapus Kategori!');
    }

    public function checkSlug(Request $request)
    {
        $slug = SlugService::createSlug(Category::class, 'slug', $request->title);
        return response()->json(['slug' => $slug]);
    }

    /**
     * Bulk Delete categories.
     */
    public function bulkDelete(Request $request)
    {
        // Validasi bahwa request memiliki array ID
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'exists:categories,id',
        ]);

        // Ambil daftar kategori berdasarkan ID yang dikirim
        $categoryList = Category::whereIn('id', $request->ids)->get();

        foreach ($categoryList as $category) {
            // Hapus gambar dari storage jika ada
            if ($category->image) {
                Storage::delete('public/' . $category->image);
            }

            // Hapus kategori dari database
            $category->delete();
        }

        return response()->json(['success' => true, 'message' => 'Kategori berhasil dihapus.']);
    }


    
}

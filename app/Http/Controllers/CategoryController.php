<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = Category::all();
        return view("adminPage.category.index", compact("categories"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("adminPage.category.create");
    }

    public function productList(string $categoryId){
        $categories = Product::where('category_id', $categoryId)->get();
        return view("adminPage.category.productInCategory", compact("categories"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Session::flash('name', $request->name);
        Session::flash('description', $request->description);
        // Validasi input
        $request->validate([
            "name" => "required|unique:categories,name",
            "description" => "nullable",
        ], [
            "name.required" => "Kategori harus diisi",
            "name.unique" => "Kategori sudah terdaftar",
        ]);


        // Menyimpan data produk jika kategori ada
        $category = Category::create([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect ke halaman produk dengan pesan sukses
        return redirect()->route("adminPage.category.index")->with('success', 'Product created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category = Category::find($id);
        return view("adminPage.category.edit", compact("category"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $category = Category::findOrFail($id);

        // Validasi input
        $request->validate([
            "name" => ["required",Rule::unique('categories', 'name')->ignore($category->id)],
            "description" => "nullable",
        ], [
            "name.required" => "Kategori harus diisi",
            "name.unique" => "Nama kategori sudah digunakan",
        ]);

        // Update data
        $category->update([
            'name' => $request->name,
            'description' => $request->description,
        ]);

        // Redirect dengan pesan sukses
        return redirect()->route("adminPage.category.index")->with('success', 'Category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $id = Category::findOrFail($id)->delete();
        return redirect()->route("adminPage.category.index")->with('success', 'Category deleted successfully');
    }
}

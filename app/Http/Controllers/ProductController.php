<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Favorite;
use App\Models\Product;
use App\Models\Product_image;
use App\Models\Shop;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function indexBuyer(Request $request)
    {
        if (Auth::user() && Auth::user()->role === 'seller') {
            $user = Auth::user();
            $shop = $user->shop;
            $products = Product::where('shop_id', $shop->id)->get();
            return view('sellerPage/products/index', compact('user', 'shop', 'products'));
        }

        if (Auth::user() && Auth::user()->role === 'admin') {
            return redirect()->route('adminPageSeller.index');
        }

        $categories = Category::all();
        $products = Product::query();

        // Search functionality
        if ($request->has('search')) {
            $searchTerm = $request->search;
            $products->where('name', 'LIKE', "%{$searchTerm}%");
        }

        // Category filter
        if ($request->has('category') && $request->category != '') {
            $products->where('category_id', $request->category);
        }

        $products = $products->with('product_images')->inRandomOrder()->get();

        return view('buyerPage.products.productList', compact('products', 'categories'));
    }

    public function indexSeller(Request $request)
    {
        // Ambil data kategori (jika diperlukan untuk dropdown)
        $categories = Category::all();

        // Ambil seller yang sedang login
        $user = Auth::user();
        $shop = Shop::where('seller_id', $user->id)->first(); // Ambil shop berdasarkan seller_id

        // Pastikan seller memiliki shop_id
        if (!$shop) {
            return redirect()->route('home')->with('error', 'Shop not found.');
        }

        // Ambil produk berdasarkan shop_id
        $products = Product::where('shop_id', $shop->id)->get();

        // Return ke view dengan data produk dan kategori
        return view('sellerPage.products.index', compact('products', 'categories'));
    }

    public function detailProduct($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::findOrFail($id);
        $photos = Product_image::where('product_id', $id)->get();

        // Kirimkan data produk ke view
        return view('sellerPage.products.detailProduct', compact('product', 'photos'));
    }

    public function detailProductBuyer($id)
    {
        // Cari produk berdasarkan ID
        $product = Product::with('product_images')->findOrFail($id);

        // Ambil related products berdasarkan category yang sama, kecuali produk yang sedang dilihat
        $relatedProducts = Product::with('product_images')
            ->where('category_id', $product->category_id)
            ->where('id', '!=', $id)
            ->take(6) // Batasi hanya 6 produk terkait
            ->get();

        $shop = Shop::findOrFail($product->shop_id);

        if (Auth::guest()) {
            $favorite = false;
            return view('buyerPage.products.index', compact('product', 'relatedProducts', 'shop', 'favorite'));
        }
        $favorite = Favorite::where('buyer_id', Auth::user()->id)
            ->where('product_id', $product->id)
            ->exists();

        // Kirimkan data produk ke view
        return view('buyerPage.products.index', compact('product', 'relatedProducts', 'shop', 'favorite'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user(); // Mendapatkan user yang sedang login
        $categories = Category::all();

        return view("sellerPage.products.create", compact("categories", "user"));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $request->validate([
            "productName" => "required|unique:products,name",
            "description" => "nullable",
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
            "stock" => "required|numeric",
            'photo' => 'required|array|max:4',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,webp,heic|max:2048',
        ], [
            "productName.required" => "Nama Produk Tidak Boleh Kosong.",
            "productName.unique" => "Nama Produk Telah Ada, Lakukan pengeditan bila ingin melakukan perubahan.",
            "price.required" => "Harga Tidak Boleh Kosong.",
            "category_id.exists" => "Kategori Tidak Terdaftar.",
            "stock.required" => "Stock Tidak Boleh Kosong.",
            "photo.required" => "Foto Produk Tidak Boleh Kosong.",
            "photo.image" => "Foto harus berupa gambar.",
            "photo.mimes" => "Foto harus berformat jpeg, png, jpg, gif, webp, atau heic.",
            "photo.max" => "Ukuran foto maksimal adalah 2048 kb.",
        ]);

        $user = Auth::user();
        $shop = Shop::where("seller_id", $user->id)->first();

        $shopId = $shop->id;
        // Simpan data produk
        $product = Product::create([
            'shop_id' => $shopId,
            'name' => $request->productName,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
        ]);

        // Simpan foto jika ada
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                // Simpan file dan ambil path-nya
                $filePath = $file->store('photos', 'public');

                // Simpan informasi file ke Product_image
                Product_image::create([
                    'product_id' => $product->id,
                    'image_path' => $filePath,
                ]);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route("sellerPage.products.index")->with('success', 'Product created successfully');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $categories = Category::all();
        $product = Product::findOrFail($id);
        $photos = Product_image::where('product_id', $id)->get();
        return view("sellerPage.products.edit", compact("product", "categories", 'photos'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            "productName" => "required|unique:products,name," . $id,
            "description" => "nullable|unique:products,description," . $id,
            "price" => "required|numeric",
            "category_id" => "required|exists:categories,id",
            "stock" => "required|numeric",
            'photo' => 'nullable|array|max:4',
            'photo.*' => 'image|mimes:jpeg,png,jpg,gif,webp,heic|max:2048',
        ], [
            "productName.required" => "Nama Produk Tidak Boleh Kosong.",
            "productName.unique" => "Nama Produk Telah Ada, gunakan nama produk lain.",
            "description.unique" => "Deskripsi Produk Telah Ada, gunakan deskripsi yang berbeda.",
            "price.required" => "Harga Tidak Boleh Kosong.",
            "category_id.exists" => "Kategori Tidak Terdaftar.",
            "stock.required" => "Stock Tidak Boleh Kosong.",
        ]);

        $user = Auth::user();
        $shop = Shop::where("seller_id", $user->id)->first();
        $shopId = $shop->id;

        // Temukan produk yang akan diperbarui
        $product = Product::findOrFail($id);
        $product->update([
            'shop_id' => $shopId,
            'name' => $request->productName,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'stock' => $request->stock,
        ]);

        // Hapus gambar yang dipilih untuk dihapus
        if ($request->has('delete_photos')) {
            foreach ($request->delete_photos as $photoId) {
                if (!str_contains($photoId, 'new-')) { // Pastikan itu bukan foto baru
                    $image = Product_image::find($photoId);
                    if ($image) {
                        // Hapus file gambar dari storage
                        Storage::disk('public')->delete($image->image_path);
                        // Hapus data gambar dari tabel Product_image
                        $image->delete();
                    }
                }
            }
        }

        // Simpan foto baru jika ada
        if ($request->hasFile('photo')) {
            foreach ($request->file('photo') as $file) {
                // Simpan file dan ambil path-nya
                $filePath = $file->store('photos', 'public');

                // Simpan informasi file ke Product_image
                Product_image::create([
                    'product_id' => $product->id,
                    'image_path' => $filePath,
                ]);
            }
        }

        // Redirect dengan pesan sukses
        return redirect()->route("sellerPage.products.index")->with('success', 'Product updated successfully');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Temukan produk yang akan dihapus
        $product = Product::findOrFail($id);

        // Hapus gambar-gambar terkait produk tersebut
        $productImages = Product_image::where('product_id', $product->id)->get();

        foreach ($productImages as $image) {
            // Hapus file gambar dari storage
            Storage::disk('public')->delete($image->image_path);

            // Hapus data gambar dari tabel Product_image
            $image->delete();
        }

        // Hapus produk dari tabel Product
        $product->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('sellerPage.products.index')->with('success', 'Product deleted successfully');
    }
    public function destroyAdmin($id)
    {
        // Temukan produk yang akan dihapus
        $product = Product::findOrFail($id);
        $category_id = $product->category_id;

        // Hapus gambar-gambar terkait produk tersebut
        $productImages = Product_image::where('product_id', $product->id)->get();

        foreach ($productImages as $image) {
            // Hapus file gambar dari storage
            Storage::disk('public')->delete($image->image_path);

            // Hapus data gambar dari tabel Product_image
            $image->delete();
        }

        // Hapus produk dari tabel Product
        $product->delete();

        // Redirect dengan pesan sukses
        return redirect()->route('adminPage.category.productList', $category_id)->with('success', 'Product deleted successfully');
    }

    public function productByShop($shopId)
    {
        $shop = Shop::findOrFail($shopId);
        $products = Product::where('shop_id', $shopId)->get();
        $products_count = Product::where('shop_id', $shopId)->count();
        $imagePaths = DB::table('product_images as pi')
            ->join('products as p', 'pi.product_id', '=', 'p.id')
            ->join('shops as s', 'p.shop_id', '=', 's.id')
            ->where('s.id', $shopId) // Jika s.id adalah integer
            ->pluck('pi.image_path');
        return view('buyerPage.shopReview.index', compact('products', 'shop', 'products_count', 'imagePaths'));
    }
}

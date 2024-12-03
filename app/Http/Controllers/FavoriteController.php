<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class FavoriteController extends Controller
{
    public function index()
    {
        if(Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to view your favorite products.');
        }
        $user = Auth::user();
        $favorites = Favorite::where('buyer_id', $user->id)
            ->with('product')
            ->get();

        return view('buyerPage.favorited.index', compact('favorites'));
    }

    public function store($productId)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login first to add product to favorites');
        }
        $product = Product::findOrFail($productId);
        $user = Auth::user();
        // Simpan favorit ke database

        $favorite = Favorite::where('buyer_id', $user->id)
            ->where('product_id', $product->id)->first();
        if ($favorite) {
            $favorite->delete();
        }else {
            Favorite::create([
                'buyer_id' => $user->id,
                'product_id' => $product->id,
            ]);
        }


        // return view('buyerPage.dashboard');
        return redirect()->back()->with('success', 'Product favorite status updated!');


        // return response()->json(['message' => 'Product added to favorites'], 200);
    }
}

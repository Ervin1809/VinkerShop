<?php

namespace App\Http\Controllers;

use App\Models\Cart_item;
use Illuminate\Http\Request;
use App\Models\CartItem;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to view your cart.');
        }

        // Mengambil cart items dengan relasi product dan shop
        $cartItems = Cart_item::with(['product.shop', 'product.product_images'])
            ->where('buyer_id', Auth::id())
            ->get();

        // Mengelompokkan items berdasarkan shop_id
        $groupedCartItems = $cartItems->groupBy('product.shop_id');

        return view('buyerPage.cart.index', compact('groupedCartItems'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to add product to cart.');
        }

        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah produk sudah ada di keranjang
        $existingCartItem = Cart_item::where('buyer_id', Auth::id())
            ->where('product_id', $request->productId)
            ->first();

        if ($existingCartItem) {
            // Tambahkan quantity ke item yang sudah ada
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();

            return redirect()->back()->with('success', 'Product quantity updated in cart.');
        }

        // Jika belum ada, tambahkan produk baru ke keranjang
        Cart_item::create([
            'buyer_id' => Auth::id(),
            'product_id' => $request->productId,
            'quantity' => $request->quantity,
        ]);

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }
    public function storeBuy(Request $request)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login to add product to cart.');
        }

        $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // Cek apakah produk sudah ada di keranjang
        $existingCartItem = Cart_item::where('buyer_id', Auth::id())
            ->where('product_id', $request->productId)
            ->first();

        if ($existingCartItem) {
            // Tambahkan quantity ke item yang sudah ada
            $existingCartItem->quantity += $request->quantity;
            $existingCartItem->save();

            return redirect()->route('cart.index')->with('success', 'Product added to cart, complete the purchase process!');
        }

        // Jika belum ada, tambahkan produk baru ke keranjang
        Cart_item::create([
            'buyer_id' => Auth::id(),
            'product_id' => $request->productId,
            'quantity' => $request->quantity,
        ]);

        return redirect()->route('cart.index')->with('success', 'Product added to cart, complete the purchase process!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $cartItem = Cart_item::findOrFail($id);
        $cartItem->delete();

        return redirect()->route('cart.index')->with('success', 'Product removed from cart successfully.');
    }
}

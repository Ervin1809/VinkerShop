<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginUserController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        // Cek role user
        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $shop = $user->shop;
            $products = Product::all();
            if ($user->role == 'admin') {
                $request->session()->regenerate();
                // return view('adminPage/dashboard', compact('user', 'shop'));
                return redirect()->route('adminPageSeller.index');
            } elseif ($user->role == 'buyer') {
                $request->session()->regenerate();
                return view('buyerPage/products/productList', compact('user', 'shop', 'products'));
            } elseif ($user->role == 'seller') {
                $request->session()->regenerate();
                $products = Product::where('shop_id', $shop->id)->get();
                return view('sellerPage/products/index', compact('user', 'shop', 'products'));
            }
        }

        // Jika gagal login
        return back()->withErrors([
            'email' => 'Email atau password salah.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}

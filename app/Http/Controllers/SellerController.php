<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class SellerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sellers = User::where('role', 'seller')->get();
        $sellerYa = Shop::select(
            'shops.id',
            'users.id as seller_id',
            'shops.shopName',
            DB::raw('COUNT(orders.shop_id) as total_order'),
            DB::raw('SUM(orders.total_amount) as total_sales')
        )
            ->leftJoin('users', 'shops.seller_id', '=', 'users.id')
            ->leftJoin('orders', 'orders.shop_id', '=', 'shops.id')
            ->where('users.role', 'seller')
            ->groupBy('users.id', 'orders.shop_id', 'shops.seller_id', 'shops.id', 'shops.shopName')
            ->orderByDesc('total_sales')
            ->get();





        $orders = Order::all();
        $totalOrders = $orders->count();
        $totalRevenue = Order::sum('total_amount');
        $avgOrdersPerSeller = $totalOrders / $sellers->count();
        $topSellers = Order::select('shop_id', DB::raw('COUNT(shop_id) as total_order, SUM(total_amount) as total_sales'))
            ->groupBy('shop_id') // Kelompokkan berdasarkan shop_id
            ->orderBy('total_sales', 'desc') // Urutkan berdasarkan total_sales secara menurun
            ->take(3) // Ambil 3 data teratas
            ->get();

        return view("adminPage.seller.sellerManagement", compact("sellers", "totalOrders", "totalRevenue", "avgOrdersPerSeller", "topSellers", "sellerYa"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("adminPage.seller.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = 'seller';

        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required'],
            'phone' => ['required', 'string', 'regex:/^08[1-9][0-9]{8,11}$/'],
            'shopName' => ['required', 'string', 'max:50', 'unique:shops,shopName'],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'email.unique' => 'Email sudah terdaftar.',
            'password.required' => 'Kata sandi wajib diisi.',
            'password.confirmed' => 'Konfirmasi kata sandi tidak cocok.',
            'shopName.unique' => 'Nama toko sudah terdaftar.',
            'shopName.required' => 'Nama toko wajib diisi.',
            'shopName.string' => 'Nama toko harus berupa teks.',
            'shopName.max' => 'Nama toko tidak boleh lebih dari 50 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus berupa nomor telepon Indonesia yang valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Buat pengguna baru
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $role,
            'phone' => $request->phone,
        ]);

        // Buat shop langsung di sini
        $shop = Shop::create([
            'shopName' => $request->shopName,
            'seller_id' => $user->id,
        ]);

        // Jika shop gagal dibuat, hapus user
        if (!$shop) {
            $user->delete();
            return redirect()->back()->withErrors(['shop_error' => 'Failed to create shop. Please try again.'])->withInput();
        }

        return redirect()->route('adminPageSeller.index')->with('success', 'Account and Shop created successfully!');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $seller = User::findOrFail($id);
        return view('adminPage.seller.edit', compact('seller'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);
        $shop = Shop::where('seller_id', $user->id)->first();
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:8'],
            'phone' => ['required', 'string', 'regex:/^08[1-9][0-9]{8,11}$/'],
            'shopName' => ['required', 'string', 'max:50', Rule::unique('shops', 'shopName')->ignore($user->id, 'seller_id')],
        ], [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa teks.',
            'name.max' => 'Nama tidak boleh lebih dari 255 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.string' => 'Email harus berupa teks.',
            'email.lowercase' => 'Email harus menggunakan huruf kecil.',
            'email.email' => 'Email harus berupa alamat email yang valid.',
            'email.max' => 'Email tidak boleh lebih dari 255 karakter.',
            'shopName.required' => 'Nama toko wajib diisi.',
            'shopName.string' => 'Nama toko harus berupa teks.',
            'shopName.max' => 'Nama toko tidak boleh lebih dari 50 karakter.',
            'phone.required' => 'Nomor telepon wajib diisi.',
            'phone.regex' => 'Nomor telepon harus berupa nomor telepon Indonesia yang valid.',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        // Buat pengguna baru
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
            'phone' => $request->phone,
        ]);

        // Buat shop langsung di sini
        $shop->update([
            'shopName' => $request->shopName,
            'seller_id' => $user->id,
        ]);

        // Jika shop gagal dibuat, hapus user
        if (!$shop) {
            $user->delete();
            return redirect()->back()->withErrors(['shop_error' => 'Failed to create shop. Please try again.'])->withInput();
        }

        return redirect()->route('adminPageSeller.index')->with('success', 'Account and Shop created successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();
        return redirect()->route('adminPageSeller.index')->with('success', 'Seller deleted successfully');
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisSellerController extends Controller
{
    // Menampilkan form registrasi
    public function create()
    {
        return view('auth.registerSeller');
    }

    // Menangani proses registrasi
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

        return redirect()->route('login')->with('success', 'Account and Shop created successfully!');
    }
}

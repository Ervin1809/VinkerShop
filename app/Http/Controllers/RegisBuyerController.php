<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisBuyerController extends Controller
{
    // Menampilkan form registrasi
    public function create()
    {
        return view('auth.registerBuyer');
    }

    // Menangani proses registrasi
    public function store(Request $request)
    {
        $role = 'buyer';

        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat pengguna baru dan simpan ke database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password), // Mengamankan password dengan Hash
            'role' => $role,
        ]);

        // Redirect ke halaman dashboard pengguna
        return redirect()->route('login')->with('success',('Registration successful! You can now log in as a buyer')); // Sesuaikan dengan rute yang diinginkan
    }
}

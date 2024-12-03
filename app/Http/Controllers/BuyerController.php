<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class BuyerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $buyers = User::where('role', 'buyer')->get();
        return view("adminPage.buyer.buyerManagement", compact("buyers"));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("adminPage.buyer.Create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $role = 'buyer';

        // Validasi input pengguna
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
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
        return redirect()->route('adminPageBuyer.index')->with('success', 'Buyer created successfully'); // Sesuaikan dengan rute yang diinginkan
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $buyer = User::find($id);
        return view('adminPage.buyer.edit', compact('buyer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Cari pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'password' => ['nullable', 'min:8'], // Password opsional, tetapi jika diisi harus minimal 8 karakter
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Update data pengguna
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->filled('password') ? Hash::make($request->password) : $user->password,
        ]);

        // Redirect ke halaman buyer dengan pesan sukses
        return redirect()->route('adminPageBuyer.index')->with('success', 'Buyer updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();
        return redirect()->route('adminPageBuyer.index')->with('success', 'Buyer deleted successfully');
    }
}

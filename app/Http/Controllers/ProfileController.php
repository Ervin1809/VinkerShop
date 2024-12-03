<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    /**
     * Show the form for editing the specified resource.
     */
    public function index()
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login first to view your profile');
        }
        // $buyer = User::find($id);
        $buyer = Auth::user();
        return view('buyerPage.settings.index', compact('buyer'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (Auth::guest()) {
            return redirect()->route('login')->with('error', 'Please login first to view your profile');
        }
        try {
            $user = User::findOrFail($id);

            // Validate without file first
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
                'password' => ['nullable', 'string', 'min:8'],
                'address' => ['nullable', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $updateData = [
                'name' => $request->name,
                'email' => $request->email,
                'address' => $request->address,
            ];

            // Handle password if provided
            if ($request->filled('password')) {
                $updateData['password'] = Hash::make($request->password);
            }

            // Handle file upload separately
            if ($request->hasFile('profilePicture')) {
                $file = $request->file('profilePicture');

                // Validate file
                $fileValidator = Validator::make(['profilePicture' => $file], [
                    'profilePicture' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048'
                ]);

                if ($fileValidator->fails()) {
                    return redirect()->back()
                        ->withErrors($fileValidator)
                        ->withInput();
                }

                try {
                    // Delete old profile picture if exists
                    if ($user->profilePicture && file_exists(storage_path('app/public/' . $user->profilePicture))) {
                        unlink(storage_path('app/public/' . $user->profilePicture));
                    }

                    $filePath = $file->store('profileUser', 'public');
                    if ($filePath) {
                        $updateData['profilePicture'] = $filePath;
                    }
                } catch (\Exception $e) {
                    return redirect()->back()
                        ->with('error', 'Gagal mengunggah gambar')
                        ->withInput();
                }
            }

            $user->update($updateData);
            return redirect()->route('profile.index')
                ->with('success', 'Profil berhasil diperbarui');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memperbarui profil')
                ->withInput();
        }
    }

    public function updatePassword(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $validator = Validator::make($request->all(), [
            'current_password' => ['required', function ($attribute, $value, $fail) use ($user) {
                if (!Hash::check($value, $user->password)) {
                    $fail('The current password is incorrect.');
                }
            }],
            'password' => ['required', 'min:8', 'confirmed'],
            'password_confirmation' => ['required']
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()->route('profile.index')
            ->with('success', 'Password updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id)->delete();
        return redirect()->route('profile.edit')->with('success', 'Buyer deleted successfully');
    }
}

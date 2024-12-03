<?php

namespace App\Http\Controllers;

use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Models\User;

class SettingController extends Controller
{
    public function sellerIndex()
    {
        return view('sellerPage.settings.index');
    }

    public function updateSellerProfile(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.$id,
            'store_name' => 'required|string|max:255',
            'address' => 'required|string',
            'profilePicture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $user = User::findOrFail($id);
        $shop = Shop::where('seller_id', $id)->first();

        if ($request->hasFile('profilePicture')) {
            if ($user->profilePicture) {
                Storage::delete($user->profilePicture);
            }
            $path = $request->file('profilePicture')->store('profile-pictures', 'public');
            $user->profilePicture = $path;
        }

        $user->name = $request->name;
        $user->email = $request->email;
        // $user->store_name = $request->store_name;
        $user->address = $request->address;
        $user->save();

        $shop->shopName = $request->store_name;
        $shop->save();



        return redirect()->back()->with('success', 'Profile updated successfully');
    }

    public function updateSellerPassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::findOrFail($id);

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully');
    }

    public function destroySellerProfile($id)
    {
        $user = User::findOrFail($id);

        if ($user->profilePicture) {
            Storage::delete($user->profilePicture);
        }

        $user->delete();

        return redirect()->route('home')->with('success', 'Account deleted successfully');
    }
}

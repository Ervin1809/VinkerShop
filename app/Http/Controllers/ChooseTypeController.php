<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChooseTypeController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("auth.chooseType");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->role == 'buyer') {
            return redirect()->route('registerBuyer.create');
        } elseif ($request->role == 'seller') {
            return redirect()->route('registerSeller.create');
        }
    }
}

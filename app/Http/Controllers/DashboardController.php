<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {}

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        $fooditems = FoodItem::all();
        $users = User::all();
        return view('dashboard', compact('fooditems', 'users'));
    }

    // DashboardController.php
    public function showUserFoodItems($id)
    {
        $user = User::findOrFail($id);
        $fooditems = FoodItem::where('user_id', $id)->get();
        $users = User::where('is_admin', false)->get();

        return view('dashboard', compact('user', 'fooditems', 'users'));
    }




    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}

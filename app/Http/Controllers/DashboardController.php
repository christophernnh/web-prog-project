<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isEmpty;

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


    public function searchUser(Request $request)
    {
        $name = $request->input('username', '');
        $searchedUsers = User::where('username', 'LIKE', '%' . $name . '%')->get();
        
        
        return view('dashboard', ['users' => $searchedUsers, 'searchedUsers' => $searchedUsers]);
    }
    // DashboardController.php
    public function showUserFoodItems($id)
    {
        $fooditems = FoodItem::where('user_id', $id)->get();
        $clickeduser = User::findOrFail($id);
        $users = User::all();

        return view('dashboard', compact('clickeduser', 'fooditems', 'users'));
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

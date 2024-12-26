<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\FoodItemType;
use App\Models\StatusType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddItemController extends Controller
{
    public function showAddItemForm()
    {
        $fooditemtypes = FoodItemType::all();
        return view('additem', compact('fooditemtypes'));
    }

    public function addItem(Request $req)
    {
        $req->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'item_type_id' => 'required|exists:food_item_types,id',
            'amount' => 'required'
        ]);

        $fooditem = new FoodItem();

        $fooditem->user_id = Auth::id();
        $fooditem->item_type_id = $req->item_type_id;
        $fooditem->status_type_id = 1;
        $fooditem->name = $req->name;
        $fooditem->description = $req->description;
        $fooditem->amount = $req->amount;
        $fooditem->save();

        return redirect()->back()->with('status', 'Item requested succesfully, please wait for further information!');
    }
}

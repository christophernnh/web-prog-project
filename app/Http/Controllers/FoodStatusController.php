<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\StatusType;
use Illuminate\Http\Request;

class FoodStatusController extends Controller
{
    public function showFoodItem($id)
    {
        $fooditem = FoodItem::findOrFail($id);
        $status_types = StatusType::all();
        return view('updatefood', compact('fooditem', 'status_types'));
    }

    public function updateFoodItem(Request $request, $id)
    {
        $fooditem = FoodItem::findOrFail($id);

        // Validate the request
        $request->validate([
            'status_type_id' => 'required|exists:status_types,id',
        ]);

        // Update the food item status
        $fooditem->status_type_id = $request->status_type_id;
        $fooditem->save();

        return redirect('/dashboard')->with('status', 'Food item status updated successfully!');
    }
}

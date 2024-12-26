<?php

namespace App\Http\Controllers;

use App\Models\FoodItem;
use App\Models\User;
use Illuminate\Http\Request;

class PickUpController extends Controller
{
    public function notifyPickup(Request $request)
    {
        $foodIds = $request->input('food_ids', []);
        if (empty($foodIds)) {
            return redirect()->back()->with('error', 'Please select at least one food item.');
        }

        FoodItem::whereIn('id', $foodIds)
            ->where('status_type_id', 1) // 'registered'
            ->update(['status_type_id' => 2]); // 'received'

        return redirect()->back()->with('status', 'Pickup notification sent!');
    }

    // public function viewPickups(Request $request)
    // {
    //     if ($request->ajax()) {
    //         $foods = FoodItem::where('status_type_id', 2)->get();
    //         return response()->json($foods);
    //     }

    //     $users = User::all(); // Fetch the users here
    //     return view('dashboard', compact('users'));
    // }

    public function viewPickups(Request $request)
    {
        if ($request->ajax()) {
            $foods = FoodItem::with('user')
                ->where('status_type_id', 2)
                ->get();

            return response()->json($foods);
        }

        $users = User::all();
        return view('dashboard', compact('users'));
    }

    public function confirmPickup(Request $request)
    {
        $foodIds = explode(',', $request->input('food_ids', ''));
        $courierNames = $request->input('courier_names', []);
        $donationLocations = $request->input('donation_locations', []);

        if (empty($foodIds) || count($foodIds) === 0 || $foodIds[0] === '') {
            return redirect()->back()->with('error', 'Please select at least one food item.');
        }

        foreach ($foodIds as $foodId) {
            FoodItem::where('id', $foodId)
                ->where('status_type_id', 1) // registered
                ->update([
                    'status_type_id' => 3, // donated
                    'courier_name' => $courierNames[$foodId] ?? null,
                    'donation_location' => $donationLocations[$foodId] ?? null,
                    'donated_at' => now()
                ]);
        }

        return redirect()->back()->with('status', 'Food items confirmed as donated!');
    }


}

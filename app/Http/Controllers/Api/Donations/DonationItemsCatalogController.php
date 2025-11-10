<?php

namespace App\Http\Controllers\Api\Donations;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; 
use App\Models\DonationItemsCatalog;

class DonationItemsCatalogController extends Controller
{
    public function index(){
        return DonationItemsCatalog::all();
    }
    public function store(Request $request){
        $validated = $request->validate([
        'item_name' => 'required|string|unique:donation_items_catalog|max:255', 
        'description' => 'nullable|string',
        ]);
        $item = DonationItemsCatalog::create($validated);
        return response()->json($item, 201); 
    }
    public function show(DonationItemsCatalog $donationItemsCatalog){
        return $donationItemsCatalog;
    }
    public function update(Request $request, DonationItemsCatalog $donationItemsCatalog){
        $validated = $request->validate([
        'item_name' => 'sometimes|required|string|max:255|unique:donation_items_catalog,item_name,'.$donationItemsCatalog->id_donation_item_catalog.',id_donation_item_catalog',
        'description' => 'sometimes|nullable|string',
        ]);
        $donationItemsCatalog->update($validated);
        return response()->json($donationItemsCatalog);
    }
    public function destroy(DonationItemsCatalog $donationItemsCatalog){
        $donationItemsCatalog->delete();
        return response()->json(null, 204); 
    }
}
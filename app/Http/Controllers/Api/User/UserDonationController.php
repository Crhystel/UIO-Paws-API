<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Donation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDonationController extends Controller
{
    /**
     * Almacena una nueva donación realizada por el usuario autenticado.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'delivery_status' => 'required|string', 
            'items' => 'required|array|min:1',
            'items.*.id_donation_item_catalog' => 'required|exists:donation_items_catalog,id_donation_item_catalog',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        try {
            DB::beginTransaction();

            $donation = Donation::create([
                'id_user' => Auth::id(),
                'donation_date' => now(),
                'delivery_status' => $validated['delivery_status'],
            ]);

            foreach ($validated['items'] as $item) {
                $donation->items()->create([
                    'id_donation_item_catalog' => $item['id_donation_item_catalog'],
                    'quantity' => $item['quantity'],
                ]);
            }

            DB::commit();

            return response()->json(['message' => 'Donación registrada con éxito.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error al registrar la donación.'], 500);
        }
    }
}
<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\ApplicationStatus;
use App\Models\DonationApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserDonationApplicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'items' => 'required|array|min:1',
            'items.*.id_donation_item_catalog' => 'required|exists:donation_items_catalog,id_donation_item_catalog',
            'items.*.quantity' => 'required|integer|min:1',
        ]);

        $pendingStatus = ApplicationStatus::where('status_name', 'Pendiente')->firstOrFail();

        DB::beginTransaction();
        try {
            $application = DonationApplication::create([
                'id_user' => Auth::id(),
                'application_date' => now(),
                'id_status' => $pendingStatus->id_status,
            ]);

            foreach ($validated['items'] as $item) {
                $application->items()->attach($item['id_donation_item_catalog'], ['quantity' => $item['quantity']]);
            }

            DB::commit();

            return response()->json(['message' => 'Solicitud de donación enviada con éxito. Un administrador la revisará pronto.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error inesperado al procesar tu solicitud.'], 500);
        }
    }
}
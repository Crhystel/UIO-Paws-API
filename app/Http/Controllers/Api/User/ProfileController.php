<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function getEmergencyContacts()
    {
        return EmergencyContact::where('id_user', Auth::id())->get();
    }

    public function storeEmergencyContact(Request $request)
    {
        $validated = $request->validate([
            'contact_name' => 'required|string|max:255',
            'contact_phone' => 'required|string|max:20',
            'relationship' => 'required|string|max:100',
        ]);

        $contact = EmergencyContact::create($validated + ['id_user' => Auth::id()]);
        return response()->json($contact, 201);
    }

    public function destroyEmergencyContact(EmergencyContact $contact)
    {
        if ($contact->id_user !== Auth::id()) {
            return response()->json(['message' => 'No autorizado'], 403);
        }
        $contact->delete();
        return response()->json(null, 204);
    }
}
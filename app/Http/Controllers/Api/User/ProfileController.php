<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\EmergencyContact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Log;
class ProfileController extends Controller
{
    public function getProfile(Request $request){
        $user=Auth::user()->load('address');
        return response()->json($user);
    }
    public function updateProfile(Request $request){
        Log::info('Datos recibidos para actualizar perfil:', $request->all());
        $user=Auth::user();
        $validated= $request->validate([
            'first_name' => 'required|string|max:255',
            'middle_name'=>'nullable|string|max:255',
            'last_name' => 'required|string|max:255',
            'second_last_name'=>'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id_user, 'id_user')],
            'phone' => 'required|string|max:20',
            'document_type' => 'required|string|max:50',
            'document_number' => 'required|string|max:50',
            'address' => 'required_if:role,User|array',
            'address.street' => 'required_with:address|string|max:255',
            'address.city' => 'required_with:address|string|max:255',
            'address.province' => 'required_with:address|string|max:255',
            'address.postal_code'=>'required_with:address|string|max:20',
            'address.country'=>'required_with:address|string|max:255',
        ]);
        
        DB::beginTransaction();
        try {
            $user->update([
                'first_name' => $validated['first_name'],
                'middle_name' => $validated['middle_name'] ?? null,
                'last_name' => $validated['last_name'],
                'second_last_name' => $validated['second_last_name'] ?? null,
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'document_type' => $validated['document_type'],
                'document_number' => $validated['document_number'],
            ]);
            if ($user->hasRole('User') && !empty($validated['address'])) {
                $address = $user->address()->updateOrCreate(
                    ['id_address' => $user->id_address], 
                    $validated['address'] 
                );
                if (!$user->id_address) {
                    $user->address()->associate($address);
                    $user->save();
                }
            }
            
            DB::commit();
            return response()->json($user->load('address'), 200);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Error al actualizar el perfil.'], 500);
        }
    }

    // Actualiza la contraseña
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required|string',
            'password' => ['required', 'string', Password::min(8), 'confirmed'],
        ]);

        $user = Auth::user();

        if (!Hash::check($validated['current_password'], $user->password_hash)) {
            return response()->json(['errors' => ['current_password' => ['La contraseña actual es incorrecta.']]], 422);
        }

        $user->update([
            'password_hash' => Hash::make($validated['password']),
        ]);

        return response()->json(['message' => 'Contraseña actualizada con éxito.'], 200);
    }
    
    // Sube/Actualiza la foto de perfil
    public function updateProfilePhoto(Request $request)
    {
        $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();
        $path = $request->file('photo')->store('profile-photos', 'public');
        
        $user->update(['profile_photo_path' => $path]);

        return response()->json(['path' => $path], 200);
    }
    
    
    public function getEmergencyContacts()
    {
        $contacts = EmergencyContact::where('id_user', Auth::id())->get();
        return response()->json($contacts);
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
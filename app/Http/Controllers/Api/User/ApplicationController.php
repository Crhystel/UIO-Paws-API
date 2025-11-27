<?php

namespace App\Http\Controllers\Api\User;

use App\Http\Controllers\Controller;
use App\Models\AdoptionApplication;
use App\Models\HomeInformation;
use App\Models\VolunteerApplication;
use App\Models\ApplicationStatus;
use App\Models\Animal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;
use App\Models\TermsAndConditions;   
use App\Models\UserTermAcceptance;
use App\Models\DonationApplication;


class ApplicationController extends Controller
{
    public function getMyApplications()
    {
        $user = Auth::user();

        $adoptions = AdoptionApplication::where('id_user', $user->id_user)
            ->with(['animal.photos', 'status:id_status,status_name']) 
            ->latest('application_date')
            ->get();

        $volunteering = VolunteerApplication::where('id_user', $user->id_user)
            ->with('status:id_status,status_name')
            ->latest('application_date')
            ->get();
        $donations = DonationApplication::where('id_user', $user->id_user)
            ->with('status:id_status,status_name')
            ->latest('application_date')
            ->get();

        return response()->json([
            'adoption_applications' => $adoptions,
            'volunteer_applications' => $volunteering,
            'donation_applications' => $donations,
        ]);
    }
    public function storeAdoption(Request $request)
    {
        $validated = $request->validate([
            'id_animal' => [
                'required',
                'exists:animals,id_animal',
                Rule::exists('animals')->where(function ($query) {
                    $query->where('status', 'Disponible');
                }),
            ],
            'home_info' => 'required|array',
            'home_info.dwelling_type' => 'required|string|max:255',
            'home_info.has_yard' => 'required|boolean',
            'home_info.yard_enclosure_type' => 'nullable|string|max:255',
            'home_info.wall_material' => 'required|string|max:255',
            'home_info.floor_material' => 'required|string|max:255',
            'home_info.room_count' => 'required|integer|min:1',
            'home_info.bathroom_count' => 'required|integer|min:1',
            'home_info.adults_in_home' => 'required|integer|min:1',
            'home_info.has_balcony' => 'required|boolean',
            'home_info.current_pet_count' => 'required|integer|min:0',
            'home_info.others_pets_description' => 'nullable|string',
            'home_info.all_members_agree' => 'required|boolean',
            'home_info.previous_pets_history' => 'nullable|string',
            'home_info.motivation_for_adoption' => 'required|string|min:20',
            'home_info.hours_pet_will_be_alone' => 'required|integer|min:0|max:24',
            'home_info.location_when_alone' => 'required|string',
            'home_info.exercise_plan' => 'required|string',
            'home_info.vacation_emergency_plan' => 'required|string',
            'home_info.behavioral_issue_plan' => 'required|string',
            'home_info.vet_reference_name' => 'nullable|string|max:255',
            'home_info.vet_reference_phone' => 'nullable|string|max:20',
            'terms_accepted' => 'required|accepted',
        ]);

        $pendingStatus = ApplicationStatus::where('status_name', 'Pendiente')->first();
        if (!$pendingStatus) {
            return response()->json(['message' => 'Error de configuración del sistema: No se encontró el estado "Pendiente".'], 500);
        }
        DB::beginTransaction();
        try {
            $application = AdoptionApplication::create([
                'id_user' => Auth::id(),
                'id_animal' => $validated['id_animal'],
                'application_date' => now(),
                'id_status' => $pendingStatus->id_status,
            ]);
            $homeInfoData = $validated['home_info'];
            $homeInfoData['id_adoption_application'] = $application->id_adoption_application;
            HomeInformation::create($homeInfoData);
            $animal = Animal::find($validated['id_animal']);
            $animal->status = 'En proceso';
            $animal->save();
            $latestTerms = \App\Models\TermsAndConditions::latest('publication_date')->first();
            if ($latestTerms) {
                UserTermAcceptance::create([
                    'id_user' => Auth::id(),
                    'id_terms_conditions' => $latestTerms->id_terms_conditions,
                    'acceptance_date' => now(),
                ]);
            }
            DB::commit();

            return response()->json(['message' => 'Solicitud de adopción enviada con éxito. Nos pondremos en contacto contigo pronto.'], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Ocurrió un error inesperado al procesar tu solicitud. Por favor, inténtalo de nuevo.'], 500);
        }
    }
    public function storeVolunteer(Request $request)
    {
        $validated = $request->validate([
            'motivation' => 'required|string|min:50|max:2000',
        ]);
        
        $pendingStatus = ApplicationStatus::where('status_name', 'Pendiente')->first();
        if (!$pendingStatus) {
            return response()->json(['message' => 'Error de configuración del sistema.'], 500);
        }

        VolunteerApplication::create([
            'id_user' => Auth::id(),
            'motivation' => $validated['motivation'],
            'application_date' => now(),
            'id_status' => $pendingStatus->id_status,
        ]);

        return response()->json(['message' => 'Solicitud de voluntariado enviada con éxito. ¡Gracias por tu interés!'], 201);
    }
}
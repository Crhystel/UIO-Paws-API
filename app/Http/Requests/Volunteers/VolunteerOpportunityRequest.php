<?php

namespace App\Http\Requests\Volunteers;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VolunteerOpportunityRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $opportunityId = $this->route('volunteer_opportunity') ? $this->route('volunteer_opportunity')->id_volunteer_opportunity : null;
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'title' => [
                $required, 'string', 'max:255',
                Rule::unique('volunteer_opportunities', 'title')->ignore($opportunityId, 'id_volunteer_opportunity')
            ],
            'description'  => "$required|string",
            'requirements' => 'nullable|string',
            'is_active'    => "$required|boolean",
        ];
    }
}
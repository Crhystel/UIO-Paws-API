<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;

class MedicalRecordRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'event_date'        => "$required|date",
            'event_type'        => "$required|string|max:255", 
            'description'       => "$required|string",
            'veterinarian_name' => 'nullable|string|max:255',
            'medication'        => 'nullable|string|max:255',
        ];
    }
}
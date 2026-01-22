<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;

class BreedRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'breed_name' => "$required|string|max:255",
            'id_species' => "$required|exists:species,id_species",
        ];
    }
}
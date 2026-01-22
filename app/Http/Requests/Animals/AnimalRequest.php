<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;

class AnimalRequest extends FormRequest
{
    public function authorize()
    {
        return true; 
    }

    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'animal_name'   => "$required|string|max:255",
            'status'        => "$required|string",
            'birth_date'    => 'nullable|date',
            'color'         => "$required|string|max:50",
            'is_sterilized' => "$required|boolean",
            'description'   => 'nullable|string',
            'id_breed'      => "$required|exists:breeds,id_breed", 
            'id_shelter'    => "$required|exists:shelters,id_shelter", 
            'sex'           => "$required|in:Macho,Hembra",
            'age'           => "$required|integer|min:0",
            'size'          => "$required|in:Pequeño,Mediano,Grande",
        ];
    }
}
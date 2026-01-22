<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class SpeciesRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $speciesId = $this->route('species') ? $this->route('species')->id_species : null;

        return [
            'species_name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('species', 'species_name')->ignore($speciesId, 'id_species')
            ]
        ];
    }
}
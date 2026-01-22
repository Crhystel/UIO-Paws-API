<?php

namespace App\Http\Requests\Shelters;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule; 

class ShelterRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $shelter = $this->route('shelter');
        $shelterId = is_object($shelter) ? $shelter->id_shelter : $shelter;

        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'shelter_name'  => [$required, 'string', 'max:255'],
            'contact_email' => [
                $required, 
                'email', 
                Rule::unique('shelters', 'contact_email')->ignore($shelterId, 'id_shelter')
            ],
            'phone'                 => [$required, 'string', 'max:20'],
            'description'           => ['nullable', 'string'],
            'address'               => [$required, 'array'],
            'address.street'        => [$required, 'string', 'max:255'],
            'address.city'          => [$required, 'string', 'max:255'],
            'address.province'      => [$required, 'string', 'max:255'],
            'address.postal_code'   => [$required, 'string', 'max:20'],
            'address.country'       => [$required, 'string', 'max:255'],
        ];
    }
}
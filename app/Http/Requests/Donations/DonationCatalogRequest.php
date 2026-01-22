<?php

namespace App\Http\Requests\Donations;

use Illuminate\Foundation\Http\FormRequest;

class DonationCatalogRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');
        $required = $isUpdate ? 'sometimes|required' : 'required';

        return [
            'item_name'       => "$required|string|max:255",
            'category'        => "$required|string|max:255",
            'quantity_needed' => "$required|integer|min:1",
            'id_shelter'      => 'nullable|integer|exists:shelters,id_shelter',
            'description'     => 'nullable|string',
        ];
    }
}
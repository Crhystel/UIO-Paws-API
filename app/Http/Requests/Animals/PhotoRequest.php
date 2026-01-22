<?php

namespace App\Http\Requests\Animals;

use Illuminate\Foundation\Http\FormRequest;

class PhotoRequest extends FormRequest
{
    public function authorize() { return true; }

    public function rules()
    {
        return [
            'photo' => 'required|image|max:5120', 
        ];
    }
}
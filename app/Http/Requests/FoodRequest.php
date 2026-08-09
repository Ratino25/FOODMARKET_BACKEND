<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class FoodRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'=> ['required', 'max:255'],
            // required saat create (POST), boleh kosong saat update (PUT/PATCH) jika gambar tidak diganti
            'picturePath'=> [($this->isMethod('PUT') || $this->isMethod('PATCH')) ? 'nullable' : 'required', 'image'],
            'description'=> ['required'],
            'ingredients'=> ['required'],
            'price'=> ['required', 'numeric'],
            'rate'=> ['required', 'numeric'],
            'types'=> 'nullable',
        ];
    }
}

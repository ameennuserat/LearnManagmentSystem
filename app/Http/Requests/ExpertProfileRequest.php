<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ExpertProfileRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'bio' => 'required|string|max:1000',
            'phone' => 'required|string|min:10|max:15',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg'
        ];
    }
}

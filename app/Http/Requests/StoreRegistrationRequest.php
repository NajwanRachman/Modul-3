<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'participant_name' => ['required', 'string', 'min:3', 'max:100'],
            'email' => ['required', 'email', 'max:100'],
        ];
    }
}
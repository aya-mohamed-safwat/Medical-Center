<?php

namespace App\Http\Requests\Clients\Profiles;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
        'name'  => 'sometimes|string|max:255',
        'email' => ['sometimes','nullable','email',
            Rule::unique('users','email')->ignore(auth()->id()),
            ],
        ];
    }
}

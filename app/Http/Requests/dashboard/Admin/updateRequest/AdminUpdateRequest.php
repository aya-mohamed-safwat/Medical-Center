<?php

namespace App\Http\Requests\dashboard\Admin\updateRequest;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email' => ['required','email',
                Rule::unique('users','email')->ignore(auth()->id())],
        ];
    }
}

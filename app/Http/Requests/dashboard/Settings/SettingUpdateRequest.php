<?php

namespace App\Http\Requests\dashboard\Settings;

use Illuminate\Foundation\Http\FormRequest;

class SettingUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'settings'          => ['required','array'],
            'settings.*.key'    => ['required','string' ],
            'settings.*.value'  => ['required','string'],
            'settings.*.type'   => ['nullable', 'string'],
            'settings.*.active' => ['nullable', 'boolean'],
        ];
    }
}

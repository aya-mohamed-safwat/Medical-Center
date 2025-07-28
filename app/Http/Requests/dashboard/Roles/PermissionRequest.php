<?php

namespace App\Http\Requests\dashboard\Roles;

use Illuminate\Foundation\Http\FormRequest;

class PermissionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'permissions' => ['required' , 'array' , 'exists:permissions,id'],
        ];
    }
}

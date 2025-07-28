<?php

namespace App\Http\Requests\dashboard\Roles;

use Illuminate\Foundation\Http\FormRequest;

class RoleRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required | string',
        ];
    }
}

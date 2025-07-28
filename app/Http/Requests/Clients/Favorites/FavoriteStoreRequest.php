<?php

namespace App\Http\Requests\Clients\Favorites;

use Illuminate\Foundation\Http\FormRequest;

class FavoriteStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctorId' => 'required|exists:users,id',
        ];
    }
}

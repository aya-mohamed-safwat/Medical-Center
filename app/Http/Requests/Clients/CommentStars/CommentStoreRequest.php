<?php

namespace App\Http\Requests\Clients\CommentStars;

use Illuminate\Foundation\Http\FormRequest;

class CommentStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'doctor_id' => 'required|integer|exists:users,id',
            'comment'   => 'required|string',
            'star'      => 'required|integer|between:1,5',
        ];
    }
}

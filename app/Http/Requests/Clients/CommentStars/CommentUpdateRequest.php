<?php

namespace App\Http\Requests\Clients\CommentStars;

use Illuminate\Foundation\Http\FormRequest;

class CommentUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'comment'   => 'sometimes|string',
            'stars'     => 'sometimes|integer|between:1,5',
        ];
    }
}

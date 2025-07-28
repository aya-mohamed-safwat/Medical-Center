<?php

namespace App\Http\Requests\dashboard\Notifications;

use Illuminate\Foundation\Http\FormRequest;

class NotifyUserRequest extends FormRequest
{

    public function rules(): array
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'title'   => 'required|string|max:255',
            'body'    => 'required|string',
        ];
    }
}

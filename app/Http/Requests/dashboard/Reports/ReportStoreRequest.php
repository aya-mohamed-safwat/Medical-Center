<?php

namespace App\Http\Requests\dashboard\Reports;

use Illuminate\Foundation\Http\FormRequest;

class ReportStoreRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'file'           => ['required','file'],
            'file_type'      => ['required','string','in:rays,tests'],
            'appointment_id' => ['required','integer','exists:appointments,id'],
            'user_id'        => ['required','integer','exists:users,id'],
        ];
    }
}

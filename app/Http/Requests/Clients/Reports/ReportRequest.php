<?php

namespace App\Http\Requests\Clients\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'string',Rule::in(['rays' , 'tests'])],
        ];
    }
}

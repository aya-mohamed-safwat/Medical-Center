<?php

namespace App\Http\Requests\dashboard\Reports;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ReportIndexRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'type'   => ['sometimes', 'string',Rule::in(['rays' , 'tests'])],
            'userId' => ['sometimes', 'integer', 'exists:users,id'],
            ];
    }
}

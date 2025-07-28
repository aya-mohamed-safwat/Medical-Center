<?php

namespace App\Services\Dashboard\Active;

use App\Http\Requests\dashboard\Active\ActiveRequest;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class ActiveService
{
    public function toggle(ActiveRequest $request): JsonResponse
    {
        $modelClass = '\\App\\Models\\'.ucfirst($request->model);
        if(!class_exists($modelClass)){
            return json('failed', 'Class not found', '', 500);
        }
        $model = $modelClass::find($request->id);
        if(!$model || !isset($model->is_active)){
            return json('failed', "Record not found or Column active not found on the model", '', 500);
        }
        $model->is_active=!$model->is_active;
        $model->save();
        return json('success', "status updated",  [$model->is_active], 200);
    }
}

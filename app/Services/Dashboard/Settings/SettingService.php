<?php

namespace App\Services\Dashboard\Settings;

use App\Http\Requests\dashboard\Settings\SettingUpdateRequest;
use App\Http\Resources\Dashboard\Settings\SettingResource;
use App\Models\Setting;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class SettingService
{
    public function update(SettingUpdateRequest $request): JsonResponse
    {
        foreach($request->input('settings') as $setting){
            Setting::updateOrCreate(
                ['key' => $setting['key']],
                [
                    'value' => $setting['value'],
                    'type' => $setting['type'] ?? 'string',
                    'is_active' => $setting['active'] ?? true,
                ]);
        }
        return json(__('response.success'),__('response.done.update'),Settingresource::collection(Setting::all()),200);
    }
}

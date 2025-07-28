<?php

namespace App\Services\Dashboard\ClientProfiles;

use App\Http\Resources\Clients\ClientProfiles\ClientProfileResource;
use App\Models\ClientProfile;
use App\Models\User;
use App\Services\BaseServices\BaseService;

class ClientProfileService extends BaseService
{
    protected $model = ClientProfile::class;
    protected $resource = ClientProfileResource::class;

    public function handleUpdate($id, array $data)
    {
        $client = User::where('role_id',3)->findOrFail($id);
        $client->update($data);
        return $client->clientProfile;
    }

    public function handleDelete($id): void
    {
        $client = User::where('role_id',3)->findOrFail($id);
        $client->delete();
    }

}

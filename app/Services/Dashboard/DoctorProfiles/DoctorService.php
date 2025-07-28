<?php

namespace App\Services\Dashboard\DoctorProfiles;

use App\Http\Resources\Dashboard\DoctorProfiles\DoctorResource;
use App\Jobs\Translation;
use App\Models\DoctorProfile;
use App\Models\User;
use App\Services\BaseServices\BaseService;
use Illuminate\Support\Arr;

class DoctorService extends BaseService
{
    protected $model    = DoctorProfile::class;
    protected $resource = DoctorResource::class;

    public function handleStore(array $data)
    {
        $doctorData = Arr::only($data, ['experience_years','min','max','price']);
        $userData   = Arr::only($data, ['name', 'email', 'password']);
        $fileData   = Arr::only($data, ['file', 'file_type']);
        $userData['role_id'] = 2 ;

        $user = User::create($userData);
        $doctor = $user->doctorProfile()->create($doctorData);

        Translation::dispatchSync($doctor->id, DoctorProfile::class, ['translations' => $data['translations']]);
        $this->relations($user, $data);
        $this->image($doctor, $fileData);
        $doctor->load('user');

        return $doctor->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $user       = User::where('role_id' , 2)->findOrFail($id);
        $userData   = Arr::only($data,['name', 'email', 'password' ,'is_active']);
        $doctorData = Arr::only($data,['experience_years','min','max','price']);

        if(isset($userdata['translations'])){
            Translation::dispatchSync($user->doctorProfile()->id, DoctorProfile::class, ['translations' => $data['translations']]);
        }

        $user->update($userData);
        $user->doctorProfile()->update($doctorData);
        $this->relations($user, $data);

        return $user->doctorProfile->load('user','specialities.attachment');
    }

    public function handleDelete($id): void
    {
        $doctor = User::where('role_id' , 2)->findOrFail($id);
        $doctor->doctorProfile()->services()->detach();
        $doctor->doctorProfile()->specialities()->detach();
        $doctor->delete();
    }

    private function relations(User $doctor, array $data): void
    {
        if (!empty($data['speciality'])) {
            $doctor->doctorProfile?->specialities()->sync($data['speciality']);
        }

        if (!empty($data['service'])) {
            $doctor->doctorProfile?->services()->sync($data['service']);
        }
    }

    private function image($doctor, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($doctor, $data);
        }
    }



}

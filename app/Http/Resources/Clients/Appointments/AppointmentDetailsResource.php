<?php

namespace App\Http\Resources\Clients\Appointments;

use App\Http\Resources\Clients\Doctors\DoctorProResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\App;

class AppointmentDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = App::getLocale();
        return [
            'id'     => $this->id,
            'status' => $this->status,
            'full_datetime' =>
                Carbon::parse($this->date)->locale($locale)->translatedFormat('l'). ' - ' .
                Carbon::parse($this->date)->translatedFormat('j F') . ' - ' .
                Carbon::parse($this->time)->format('g:i A'),
            'doctor' => $this->whenLoaded('doctor' , function () {
                return [
                    'id'         => $this->doctor->user->id,
                    'name'       => $this->doctor->user->name,
                    'image'      => $this->doctor->image,
                    'speciality' => $this->doctor?->specialities?->firstwhere('parent_id','!=',null)?->name
                        ?? $this->doctor?->specialities?->firstwhere('parent_id',null)?->name,
                ];
            }),
            'client' => $this->whenLoaded('client' , function () {
                return [
                    'id'    => $this->client->user->id,
                    'name'  => $this->client->user->name
                ];
            }),
        ];
    }
}

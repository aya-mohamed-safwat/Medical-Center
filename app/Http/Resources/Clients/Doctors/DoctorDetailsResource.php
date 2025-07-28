<?php

namespace App\Http\Resources\Clients\Doctors;

use App\Http\Resources\Clients\CommentStars\CommentStarResource;
use App\Http\Resources\Dashboard\Schedule\ScheduleResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use function App\Helpers\availableTimes;

class DoctorDetailsResource extends JsonResource
{
    public function toArray(Request $request): array
    {

        return [
            'doctor' => new DoctorProfileResource($this),
            'schedule' =>  ScheduleResource::collection($this->doctorProfile->schedules),
            'about_doctor' => [
                'bio' => optional($this->doctorProfile?->translation)->bio,
                'certificates' => $this->doctorProfile?->certificates?->pluck('file_path'),
                'working_hours'
            ],
            'ratings' => CommentStarResource::collection($this->whenLoaded('commentStars')),
            'stars' =>[
                'five'  => $this->commentStars->where('stars',5)->count(),
                'four'  => $this->commentStars->where('stars',4)->count(),
                'three' => $this->commentStars->where('stars',3)->count(),
                'two'   => $this->commentStars->where('stars',2)->count(),
                'one'   => $this->commentStars->where('stars',1)->count(),
                ],
        ];
    }

}

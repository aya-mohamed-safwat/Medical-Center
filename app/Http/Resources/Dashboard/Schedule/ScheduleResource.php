<?php

namespace App\Http\Resources\Dashboard\Schedule;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\App;
use function App\Helpers\splitTimeRange;

class ScheduleResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        $locale = App::getLocale();
        return [
            'id'    => $this->id,
            'date'  => $this->date,
            'from'  => $this->from,
            'to'    => $this->to,
            'day'   => Carbon::parse($this->date)->locale($locale)->translatedFormat('l'),
            'doctorTimes'   => splitTimeRange($this->from, $this->to, $this->doctorProfile->max),
        ];
    }
}

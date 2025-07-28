<?php

namespace App\Helpers;

use App\Enums\BookingStatus;
use App\Models\Appointment;
use App\Models\Schedule;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Collection;

if (!function_exists('json'))
{
    function json($status , $message , $data , $code): JsonResponse
    {
        $response = ['status' => $status];
        if(!empty($message)) $response['message'] = $message;
        if(!empty($data)) $response['data'] = $data;

        return response()->json($response, $code);
    }
}

if (!function_exists('splitTimeRange'))
{
    function splitTimeRange($from, $to , int $duration): array
    {
        $start = carbon::parse($from);
        $end = carbon::parse($to);

        $times = [];
        while ($start->copy()->addMinutes($duration)->lte($end)) {
            $times[] = $start->format('H:i');
            $start = $start->addMinutes($duration);
        }
        return $times;
    }
}

if (!function_exists('availableTimes'))
{
    function availableTimes(int $doctorId , $date): array|Collection
    {
        $schedules = Schedule::where('doctor_profile_id', $doctorId)
            ->active(1)
            ->where('date', $date)
            ->get();

        if($schedules->isEmpty()){
            return collect();
        }
        $availableTimes = [];

        foreach ($schedules as $schedule) {
            $availableTimes = array_merge(
                $availableTimes,
                splitTimeRange($schedule->from, $schedule->to, $schedule->doctorProfile->max)
            );
        }

        $bookedTimes = Appointment::where('doctor_profile_id', $doctorId)
            ->where('date' , $date)
            ->whereNotIn('status', [BookingStatus::Cancelled , BookingStatus::Completed] )
            ->pluck('time')
            ->map(fn($time) => Carbon::parse($time)->format('H:i'))
            ->toArray();
        $available = collect($availableTimes);
        $freeTimes = collect(array_diff($availableTimes, $bookedTimes));


        return $available->map(function($item) use($freeTimes){
            return[
                'time'    => $item,
                'is_free' => $freeTimes->contains($item),
            ];
        });
    }
}

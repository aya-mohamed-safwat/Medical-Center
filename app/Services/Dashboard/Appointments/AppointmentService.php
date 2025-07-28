<?php

namespace App\Services\Dashboard\Appointments;

use App\Enums\BookingStatus;
use App\Http\Resources\Clients\Appointments\AppointmentDetailsResource;
use App\Http\Resources\Clients\Appointments\AppointmentResource;
use App\Models\Appointment;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use function App\Helpers\json;

class AppointmentService extends BaseService
{
    protected $model = Appointment::class;
    protected $resource = AppointmentResource::class;

    public function index($request): JsonResponse
    {
        $appointmentsQuery = Appointment::query();
        $appointmentsData  = $appointmentsQuery
            ->with(['doctor.user' => function ($query) {
                $query->withCount('commentStars as reviews_count')
                    ->withAvg('commentStars as average_rating', 'stars');
            },
                'doctor.specialities.translation', 'doctor.attachment', 'client.user'])
            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status' , $request->status);
            })
            ->when($request->filled('doctorId'), function ($query) use ($request) {
                $query->where('doctor_profile_id' , $request->doctorId);
            })
            ->when($request->filled('clientId'), function ($query) use ($request) {
                $query->where('client_profile_id' , $request->clientId);
            })
            ->latest()
            ->paginate();

        AppointmentResource::wrap('appointmentsData');
        return json(__('response.success'),__('response.index'),AppointmentResource::collection($appointmentsData)->response()->getData(),200);
    }

    public function show($id): JsonResponse
    {
        $appointmentData = Appointment::with([
            'doctor.user' => function ($query) {
                $query->withCount('commentStars as reviews_count')
                    ->withAvg('commentStars as average_rating', 'stars');
            }
            ,'doctor.specialities.translation'
            ,'doctor.attachment',])
            ->where('id', $id)
            ->firstOrFail();

        return json(__('response.success'),__('response.index'),new AppointmentDetailsResource($appointmentData),200);
    }

    public function handleUpdate($id, array $data)
    {
        $appointment = Appointment::findOrFail($id);
        $status = BookingStatus::from($data['status']);
        $appointment->update(['status' => $status->value]);
        return $appointment;
    }

}

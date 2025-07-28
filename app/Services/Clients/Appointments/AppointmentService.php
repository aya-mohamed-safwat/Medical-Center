<?php

namespace App\Services\Clients\Appointments;

use App\Enums\BookingStatus;
use App\Http\Resources\Clients\Appointments\AppointmentDetailsResource;
use App\Http\Resources\Clients\Appointments\AppointmentResource;
use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class AppointmentService extends BaseService
{
    protected $model = Appointment::class;
    protected $resource = AppointmentResource::class;
    protected $user;

    public function __construct()
    {
        $this->user = auth()->user();
    }

    public function index($request): JsonResponse
    {
        $appointmentQuery = Appointment::query();
        $appointmentData = $appointmentQuery
            ->with(['doctor.user' => function ($query) {
                $query->withCount('commentStars as reviews_count')
                ->withAvg('commentStars as average_rating', 'stars');
            }
            ,'doctor.specialities' ,'doctor.attachment',])
            ->where('client_profile_id' , $this->user->clientProfile->id)

            ->when($request->filled('status'), function ($query) use ($request) {
                $query->where('status' , $request->status);
            })

            ->when($request->filled('name'), function ($query) use ($request) {
                $query->orWhereHas('doctor.user', function ($q) use ($request) {
                    $q->where('name', 'LIKE', "%{$request->name}%");
                });
                $query->whereHas('speciality', function ($q) use ($request) {
                    $q->whereTranslationLike('name', "%{$request->name}%");
                });
            })
            ->latest()
            ->paginate();

        AppointmentResource::wrap('appointmentData');
        return json(__('response.success'),__('response.index'),AppointmentResource::collection($appointmentData)->response()->getData(),200);
    }

    public function show($id): JsonResponse
    {
        $appointmentData = $this->user->clientProfile->appointments()
            ->where('id', $id)
            ->with(['doctor.user' => function ($query) {
                    $query->withCount('commentStars as reviews_count')
                        ->withAvg('commentStars as average_rating', 'stars');
                }
                ,'doctor.specialities' ,'doctor.attachment',])
            ->firstOrFail();
        return json(__('response.success'),__('response.show'),new AppointmentDetailsResource($appointmentData),200);
    }

    public function handleStore(array $data)
    {
        $doctor = DoctorProfile::findOrFail($data['doctor_profile_id']);
        $appointmentData = Arr::only($data,['doctor_profile_id','service_id','speciality_id','offer_id','date','time','note']);
        $appointmentData['duration'] = $doctor->max;
        $appointmentData['price']    = $doctor->price;
        $appointmentData['status']   = BookingStatus::Pending;

        $appointment = $this->user->clientProfile->appointments()->create($appointmentData);

        if(isset($data['offer_id'])){
           $result = $this->bookSession($data , $appointment->id);
            if (!$result['success']) {
                $appointment->delete();
                throw new \Exception($result['message'], $result['code'] ?? 400);
            }
        }
        $appointment->load(['doctor.user' ,'doctor.specialities' ,'doctor.attachment']);
        return $appointment;
    }

    public function handleUpdate($id , array $data)
    {
        $appointment = $this->user->clientProfile->appointments()->findOrFail($id);
        if(!$appointment->status->canBeEdited()){
            throw new \Exception('cannot update this appointment',  400);
        }
        $appointmentData = Arr::only($data,['date','time','note']);
        $appointment->update($appointmentData);

        return $appointment;
    }

    public function canceled($id): JsonResponse
    {
        $appointment = $this->user->clientProfile->appointments()->findOrFail($id);
        if(!$appointment->status->canBeCancelled() ){
            throw new \Exception('cannot cancel this appointment',  400);
        }
        $appointment->update([
            'status' => BookingStatus::Cancelled,
            'canceled_at' => now(),
            'canceled_by' => auth()->id()
        ]);
        return json(__('response.success') , __('response.done.cancel') , '' ,200);
    }

    public function bookSession(array $data , $appointmentId): array
    {
        $clientOffer = $this->user->clientprofile->clientOffers()
            ->where('offer_id',$data['offer_id'])
            ->where('is_paid' , true)
            ->where('remaining_sessions' , '>' ,0)
            ->first();

        if(!$clientOffer)
        {
            return [
                'success' => false,
                'message' => 'You don\'t have a session available',
                'code' => 403
            ];
        }
        $clientOffer->decrement('remaining_sessions');
        return ['success' => true,];
    }
}

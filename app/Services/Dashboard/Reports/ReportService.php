<?php
namespace App\Services\Dashboard\Reports;

use App\Enums\BookingStatus;
use App\Http\Resources\Dashboard\Reports\ReportResource;
use App\Models\Appointment;
use App\Models\Report;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use function App\Helpers\json;

class ReportService extends BaseService
{
    protected $model    = Report::class;
    protected $resource = ReportResource::class;

    public function index($request): JsonResponse
    {
        $reportQuery = Report::query();
        $reportData  = $reportQuery
            ->when($request->filled('type'), function ($query) use ($request) {
                $query->whereHas('attachment', function ($q) use ($request){
                    $q->where('file_type', $request->get('type'));
                });
            })->when($request->filled('userId'), function ($query) use ($request) {
                $query->where('user_id',$request->get('userId'));
            })->latest()
            ->paginate();
        ReportResource::wrap('reportData');
        return json( __('response.success'), __('response.index'),ReportResource::collection($reportData)->response()->getData(),200);
    }

    public function handleStore(array $data)
    {
        $session = Appointment::findOrFail($data['appointment_id']);
        if($session->status != BookingStatus::Completed) {
            throw new \Exception('Appointment must be completed before adding a report.');
        }
        $fileData   = Arr::only($data , ['file' , 'file_type']);
        $report     = Report::create([
            'appointment_id' => $data['appointment_id'],
            'user_id'        => $data['user_id'],
            ]);

        $this->createFile($report, $fileData);
        return $report->refresh();
    }

}

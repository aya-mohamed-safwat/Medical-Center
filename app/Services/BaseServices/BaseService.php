<?php

namespace App\Services\BaseServices;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use function App\Helpers\json;

abstract class BaseService
{
    protected $model ;
    protected $resource ;

    public function index($request): JsonResponse
    {
        $modelQuery = $this->model::query();
        $modelData = $modelQuery
            ->when($request->filled('active'), function ($query) use ($request) {
                $query->active($request->active);
            })
            ->latest()
            ->paginate();
        $this->resource::wrap('modelData');
        return json( __('response.success'), __('response.index'),$this->modelCollection($modelData)->response()->getData(),200);
    }

    public function show($id): JsonResponse
    {
        $record = $this->model::findOrFail($id);
        return json(__('response.success'),__('response.show'), $this->modelResource($record),200);
    }

    public function store(array $data): JsonResponse
    {
        DB::beginTransaction();
        try {
            $record = $this->handleStore($data);
            $record->save();
            $record->refresh();
            DB::commit();
            return json(__('response.success'), __('response.done.store'), $this->modelResource($record), 200);
        }catch (\Exception $e){
            DB::rollBack();
            Log::error(json_encode($e->getMessage()));
            return json(__('response.failed'), __('response.error.store'),$e->getMessage(), 500);
        }
    }

    protected function handleStore(array $data)
    {
        return $this->model::create($data);
    }

    public function update($id , array $data): JsonResponse
    {
        DB::beginTransaction();
        try{
            $record = $this->handleUpdate($id , $data);
            DB::commit();
            return json(__('response.success'), __('response.done.update'), $this->modelResource($record), 200);
        }catch(\Exception $e){
            DB::rollBack();
            Log::error(json_encode($e->getMessage()));
            return json(__('response.failed'), __('response.error.update'), '', 500);
        }
    }

    public function handleUpdate($id , array $data)
    {
        $record = $this->model::findOrFail($id);
        $record->update($data);
        return $record;
    }

    public function destroy($id):JsonResponse
    {
        try {
            $this->handleDelete($id);
            return json(__('response.success'), __('response.done.delete'), '', 200);
        } catch (\Exception $e) {
            Log::info(json_encode($e->getMessage()));
            return json(__('response.failed'), __('response.error.delete'), '', 404);
        }
    }

    public function handleDelete($id): void
    {
        $record = $this->model::findOrFail($id);
        $record->delete();
    }

    public function createFile(Model $model ,array $data): void
    {
        $user = auth()->user();

        $uploaded = $data['file'];
        $path = Storage::disk('public')->put('attachments', $uploaded);

        $model->attachment()->create([
            'original_name'    => $uploaded->getClientOriginalName(),
            'file_path'        => $path,
            'file_name'        => basename($path),
            'file_type'        => $data['file_type'],
            'size'             => $uploaded->getSize(),
            'extension'        => $uploaded->getClientOriginalExtension(),
            'uploaded_by_id'   => $user->id,
            'uploaded_by_type' => $user->role->name,
        ]);
    }

    public function modelResource($data)
    {
        return new ($this->resource)($data);
    }

    public function modelCollection($data)
    {
        return ($this->resource)::collection($data);
    }
}

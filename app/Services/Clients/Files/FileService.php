<?php

namespace App\Services\Clients\Files;

use App\Http\Resources\Clients\Images\ImageResource;
use App\Models\Attachment;
use App\Services\BaseServices\BaseService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;
use function App\Helpers\json;

class FileService extends BaseService
{
    protected $model    = Attachment::class;
    protected $resource = ImageResource::class;

    public function getImage(): JsonResponse
    {
       $image = Attachment::where('fileable_type' ,'\\App\\Models\\clientProfile')
           ->where('fileable_id', auth()->user()->clientProfile->id)
           ->latest()
           ->first();

        return json(__('response.success'),__('response.show'), new ImageResource($image),200);
    }

    public function handleStore(array $data)
    {
        $user = auth()->user();

        $uploaded = $data['file'];
        $path = Storage::disk('public')->put('attachments', $uploaded);

        $attachment = Attachment::create([
            'original_name'    => $uploaded->getClientOriginalName(),
            'file_path'        => $path,
            'file_name'        => basename($path),
            'file_type'        => 'profile',
            'size'             => $uploaded->getSize(),
            'extension'        => $uploaded->getClientOriginalExtension(),
            'fileable_id'      => $user->clientProfile->id,
            'fileable_type'    => '\\App\\Models\\clientProfile',
            'uploaded_by_id'   => $user->id,
            'uploaded_by_type' => $user->role->name,
        ]);
        $attachment->save();
        $attachment->refresh();
        return $attachment;
    }

}

<?php

namespace App\Services\Dashboard\Attachments;

use App\Http\Resources\Dashboard\Attachments\AttachmentResource;
use App\Models\Attachment;
use App\Services\BaseServices\BaseService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AttachmentService extends BaseService
{
    protected $model = Attachment::class;
    protected $resource = AttachmentResource::class;

    public function handleStore(array $data)
    {
        $user = auth()->user();
        $uploaded = $data['file'];
        $path = Storage::disk('public')->put('attachments', $uploaded);

        $attachment = Attachment::create([
            'original_name'    => $uploaded->getClientOriginalName(),
            'file_path'        => $path,
            'file_name'        => basename($path),
            'file_type'        => $data['file_type'],
            'size'             => $uploaded->getSize(),
            'extension'        => $uploaded->getClientOriginalExtension(),
            'fileable_id'      => $data['fileable_id'],
            'fileable_type'    => "App\\Models\\".Str::studly($data['fileable_type']),
            'uploaded_by_id'   => $user->id,
            'uploaded_by_type' => $user->role->name,
        ]);
        $attachment->save();
        $attachment->refresh();
        return $attachment;
    }

    public function handleUpdate( $id , array $data)
    {
        $attachment = Attachment::query()->findOrFail($data['id']);
        if($attachment && Storage::disk('public')->exists($attachment->file_path))
        {
            Storage::disk('public')->delete($attachment->file_path);
        }
        $path = Storage::disk('public')->put('attachments',  $data['file']);
        $attachment->update(['file_path' => $path,]);
        return $attachment;
    }

    public function handleDelete($id): void
    {
        $file = Attachment::findOrFail($id);
        Storage::disk('public')->delete($file->file_path);
        $file->delete();
    }
}

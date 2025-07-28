<?php

namespace App\Services\Dashboard\Sliders;

use App\Http\Resources\Dashboard\Sliders\SliderDetailsResource;
use App\Jobs\Translation;
use App\Models\Slider;
use App\Services\BaseServices\BaseService;
use Illuminate\Support\Arr;

class SliderService extends BaseService
{
    protected $model = Slider::class;
    protected $resource = SliderDetailsResource::class;

    public function handleStore(array $data)
    {
        $sliderData = Arr::only($data, ['discount_id','start_at','end_at','order', 'type' ,'redirect_type' ,'redirect_id']);
        $fileData   = Arr::only($data , ['file' , 'file_type']);

        $slider = Slider::create($sliderData);

        $this->image($slider , $fileData);
        Translation::dispatchSync($slider->id ,Slider::class, ['translations' => $data['translations']]);
        return $slider->refresh();
    }

    public function handleUpdate($id, array $data)
    {
        $slider = Slider::findOrFail($id);
        $offerData = Arr::only($data, ['discount_id','start_at','end_at','order', 'type','is_active','redirect_type' ,'redirect_id']);

        if(isset($data['translations'])) {
            Translation::dispatchSync($slider->id ,Slider::class, ['translations' => $data['translations']]);
        }
        $slider->update($offerData);
        return $slider;
    }

    private function image(Slider $slider, array $data): void
    {
        if (!empty($data['file']))
        {
            $this->createFile($slider, $data);
        }
    }
}

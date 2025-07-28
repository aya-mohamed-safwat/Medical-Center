<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Log;

class Translation implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $id, public string $model ,public array $data){}

    public function handle(): void
    {
        if ($this->data) {
            $model = app($this->model)->find($this->id);
            foreach ($this->data['translations'] ?? [] as $locale => $translation) {
                $model->translateOrNew($locale)->fill($translation);
            }
            $model->save();
        }
    }
}

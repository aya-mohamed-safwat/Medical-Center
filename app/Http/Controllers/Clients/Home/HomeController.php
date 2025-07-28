<?php

namespace App\Http\Controllers\Clients\Home;

use App\Services\Clients\Home\HomeService;

class HomeController
{
    public function __construct(protected HomeService $homeService){}

    public function home()
    {
        return $this->homeService->home();
    }
}

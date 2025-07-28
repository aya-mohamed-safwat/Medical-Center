<?php

use Illuminate\Support\Facades\Broadcast;

Broadcast::channel('App.Models.AdminProfile.{id}', function ($admin, $id) {
    return (int)$admin->id === (int)$id;
});

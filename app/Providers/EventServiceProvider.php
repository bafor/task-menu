<?php

namespace App\Providers;

use App\Listeners\MenuEventSubscriber;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $subscribe = [
        MenuEventSubscriber::class
    ];
}

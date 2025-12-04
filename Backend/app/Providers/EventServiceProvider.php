<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Event;

class EventServiceProvider extends ServiceProvider
{
    /**
     * Los eventos del sistema y sus listeners
     *
     * @var array
     */
    protected $listen = [
        // 'App\Events\ExampleEvent' => [
        //     'App\Listeners\ExampleListener',
        // ],
    ];

    /**
     * Registro de cualquier servicio de eventos
     */
    public function boot(): void
    {
        parent::boot();
    }
}


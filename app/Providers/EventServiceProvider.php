<?php

namespace App\Providers;

use App\Listeners\ClienteLoginListener;
use App\Listeners\PasswordResetListener;
use Illuminate\Auth\Events\Login;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        Login::class => [
            ClienteLoginListener::class,
        ],

        PasswordReset::class => [
            PasswordResetListener::class,
        ],
    ];

    public function boot(): void
    {
        //
    }
}

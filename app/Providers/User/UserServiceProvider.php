<?php

namespace App\Providers\User;

use Illuminate\Support\ServiceProvider;

use App\User;
use App\Observers\User\UserObserver;

class UserServiceProvider extends ServiceProvider
{
    public function register()
    {
        //
    }

    public function boot()
    {
        User::observe(UserObserver::class);

        view()->composer([

            // What views should be shared with some data
            'components.user.navbar',
            'user.profiles.index',
            'user.profiles.card',
            'user.checkout.index',
            'user.password.edit',
            'user.password.card',
        ],
            // What data should be shared...
            function($view){
            $user = auth()->user();

            $view->with('user', $user);
        });
    }
}

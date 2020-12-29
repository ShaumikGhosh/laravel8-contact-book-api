<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\User\UserInterface;
use App\Services\User\UserService;
use Illuminate\Support\Facades\Schema;
use App\Services\Contact\ContactInterface;
use App\Services\Contact\ContactService;
use App\Services\Admin\AdminInterface;
use App\Services\Admin\AdminService;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(
            UserInterface::class,
            UserService::class
        );

        $this->app->bind(
            ContactInterface::class,
            ContactService::class
        );

        $this->app->bind(
            AdminInterface::class,
            AdminService::class
        );
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }
}

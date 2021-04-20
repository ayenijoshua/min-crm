<?php

namespace App\Providers;

use App\Http\Controllers\UserController;
use App\Repositories\Interfaces\RepositoryInterface;
use App\Repositories\UserRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->when(UserController::class)
          ->needs(RepositoryInterface::class)
          ->give(function () {
              return UserRepository::class;
          });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}

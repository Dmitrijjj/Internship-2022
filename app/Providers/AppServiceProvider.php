<?php

namespace App\Providers;

use App\Components\Task\TaskRepository;
use App\Components\Task\TaskRepositoryContract;
use App\Components\User\UserRepository;
use App\Components\User\UserRepositoryContract;
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
        $this->app->bind(TaskRepositoryContract::class, TaskRepository::class);
        $this->app->bind(UserRepositoryContract::class, UserRepository::class);
    }
}

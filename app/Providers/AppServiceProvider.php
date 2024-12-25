<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(\App\Interfaces\NoteRepositoryInterface::class, \App\Repositories\NoteRepository::class);
        $this->app->bind(\App\Interfaces\CategoryRepositoryInterface::class, \App\Repositories\CategoryRepository::class);

    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

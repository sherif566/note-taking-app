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
        $this->app->when(\App\Services\CategoryNoteService::class)
        ->needs(\App\Repositories\Interfaces\RepositoryInterface::class)
        ->give(\App\Repositories\NoteRepository::class);

        $this->app->when(\App\Services\NoteService::class)
                  ->needs(\App\Repositories\Interfaces\RepositoryInterface::class)
                  ->give(\App\Repositories\NoteRepository::class);

        $this->app->when(\App\Services\CategoryService::class)
                  ->needs(\App\Repositories\Interfaces\RepositoryInterface::class)
                  ->give(\App\Repositories\CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}

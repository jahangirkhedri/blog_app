<?php

namespace Blog;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    private $namespace = 'Blog\Http\Controllers';

    public function register()
    {
        $this->loadMigrationsFrom(__DIR__ . '/Migrations');
    }


    public function boot()
    {
        if (!$this->app->routesAreCached()) {
            Route::prefix('api')
                ->middleware('api')
                ->namespace($this->namespace)
                ->group(__DIR__ . "/routes/api.php");
        }
    }
}

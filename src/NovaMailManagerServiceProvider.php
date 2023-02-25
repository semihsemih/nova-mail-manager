<?php

namespace BinaryBuilds\NovaMailManager;

use BinaryBuilds\NovaMailManager\Http\Middleware\Authorize;
use BinaryBuilds\NovaMailManager\Resources\NovaMailResource;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class NovaMailManagerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'nova-mail-manager');

        $this->app->register(\BinaryBuilds\LaravelMailManager\LaravelMailManagerServiceProvider::class);

        $this->app->booted(function () {
            $this->routes();
        });

        Nova::resources([
            NovaMailResource::class,
        ]);

        Nova::serving(function (ServingNova $event) {
            //
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova', Authorize::class])
                ->prefix('nova-vendor/nova-mail-manager')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

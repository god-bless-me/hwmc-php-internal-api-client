<?php

namespace PdInternalApi;

class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->configure('internal_api');
        $this->app->singleton('internal.api', function () {
            return new Client(config('internal_api.client'));
        });
        foreach (config('internal_api.client') as $key => $config) {
            $this->app->singleton('internal.api.' . $key, function () use ($key) {
                return $this->app['internal.api']->app($key);
            });
        }

    }
}
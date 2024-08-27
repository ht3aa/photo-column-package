<?php

namespace Ta3leem\PhotoColumn;

use Illuminate\Support\ServiceProvider;

class PhotoColumnServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/Views', 'photo-column');

        $this->publishes([
            __DIR__.'/Config/PhotoColumn.php' => config_path('photo-column.php'),
        ], 'photo-column-config');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register() {}
}

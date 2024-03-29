<?php

namespace Mayahkw\CMS;

use Illuminate\Support\ServiceProvider;

class CmsServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('mycms', function () {
            return new MyCmsClass(['id' => 1]);
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'my_cms');

        $this->publishes([
            __DIR__ . '/../resources/views' => resource_path('views/vendor/my_cms')
        ], 'my_cms_cms_views');

        $this->publishes([
            __DIR__ . '/../resources/js/CMS' => resource_path('js/Pages/My/Cms')
        ], 'my_cms_cms_vue');
    }
}

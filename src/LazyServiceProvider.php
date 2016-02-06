<?php

namespace samjoyce777\lazy;

use Illuminate\Support\ServiceProvider;
use Illuminate\Html\FormBuilder;

class LazyServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/js' => app()->basePath().DIRECTORY_SEPARATOR.'resources/assets/js/vendor/samjoyce777/lazy',
        ], 'public');

        $this->publishes([
            __DIR__.'/config/lazy.php' => config_path('lazy.php'),
        ], 'config');

        if (! $this->app->routesAreCached()) {
            require 'routes.php';
        }
    }


    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerHtmlBuilder();

        $this->registerFormBuilder();

        $this->app->alias('lazy', 'samjoyce777\lazy\Lazy');
        $this->app->alias('form', 'Illuminate\Html\FormBuilder');

        $config = require(__DIR__.'/config/lazy.php');

        config($config);
    }

    /**
     * Register the HTML builder instance.
     *
     * @return void
     */
    protected function registerHtmlBuilder()
    {
        $this->app->bindShared('lazy', function($app)
        {
            return new Lazy($app['url']);
        });
    }

    /**
     * Register the form builder instance.
     *
     * @return void
     */
    protected function registerFormBuilder()
    {
        $this->app->bindShared('form', function($app)
        {
            $form = new FormBuilder($app['lazy'], $app['url'], $app['session.store']->getToken());

            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('lazy', 'form');
    }


}

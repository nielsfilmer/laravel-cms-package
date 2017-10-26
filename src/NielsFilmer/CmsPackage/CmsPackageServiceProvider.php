<?php namespace NielsFilmer\CmsPackage;

use Illuminate\Support\ServiceProvider;
use Laracasts\Flash\FlashServiceProvider;
use NielsFilmer\EloquentLister\EloquentListerServiceProvider;

class CmsPackageServiceProvider extends ServiceProvider {

    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;


    /**
     * Register the config and view paths
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__ . '/../../views', 'cms-package');

        $this->publishes([
            __DIR__ . '/../../views' => base_path('resources/views/vendor/cms-package'),
        ]);
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(FlashServiceProvider::class);
        $this->app->register(EloquentListerServiceProvider::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }

}

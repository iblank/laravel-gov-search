<?php namespace iblank\GovSearch;


use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Str;

class GovSearchServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{

        if ($this->isLegacyLaravel() || $this->isOldLaravel())
        {
            $this->package('iblank/laravel-gov-search', 'iblank/govsearch');
        }

        $loader = \Illuminate\Foundation\AliasLoader::getInstance();
        $loader->alias('GovSearch', 'iblank\GovSearch\Facades\GovSearch');
	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		if ($this->isLegacyLaravel() || $this->isOldLaravel())
        {
            $this->app['govsearch'] = $this->app->share(function($app)
            {
                $key = \Config::get('iblank/govsearch::KEY');
                $affiliate = \Config::get('iblank/govsearch::Affiliate');
                $defaults = \Config::get('iblank/govsearch::DEFAULTS');
                return new GovSearch($key, $affiliate, $defaults);
            });

            return;
		}

        $this->publishes(array(__DIR__ . '/../../config/govsearch.php' => config_path('govsearch.php')));

        $this->app->bindShared('govsearch', function()
        {
            return $this->app->make('iblank\GovSearch\GovSearch', [config('govsearch.KEY'), config('govsearch.Affiliate'), config('govsearch.DEFAULTS')]);
        });
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array('govsearch');
	}

    public function isLegacyLaravel()
    {
        return Str::startsWith(Application::VERSION, array('4.1.', '4.2.'));
    }

    public function isOldLaravel()
    {
        return Str::startsWith(Application::VERSION, '4.0.');
    }

}

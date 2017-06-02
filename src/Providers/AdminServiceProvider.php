<?php

namespace WTG\Admin\Providers;

use WTG\Admin\Services\Stats;
use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\ServiceProvider;
use Barryvdh\Snappy\ServiceProvider as SnappyServiceProvider;

/**
 * Admin service provider
 *
 * @package     WTG\Admin
 * @subpackage  Providers
 * @author      Thomas Wiringa <thomas.wiringa@gmail.com>
 */
class AdminServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes.php');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'admin');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'admin');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(SnappyServiceProvider::class);
        $this->app->alias("PDF", SnappyPdf::class);

        $this->app->bind(Stats::class);
    }
}

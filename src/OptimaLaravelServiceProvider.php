<?php
/**
 * Created by PhpStorm.
 * User: PirateKing
 * Date: 4/14/2016
 * Time: 12:53 PM
 */

namespace Optimait\Laravel;

use Illuminate\Support\ServiceProvider;

class OptimaLaravelServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        require_once 'Helpers/dateHelpers.php';
        require_once 'Helpers/helpers.php';
        require_once 'Helpers/render.php';

        $this->handleConfigs();
        $this->handleMigrations();
        $this->handleViews();
        $this->handleTranslations();
        $this->handleRoutes();
        $this->handleAssets();
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

    private function handleConfigs() {
        $this->publishes([
            __DIR__.'/../config/resize.php' => 'config/resize.php',
        ]);
    }

    private function handleTranslations() {

    }

    private function handleViews() {

    }

    private function handleMigrations() {

        $this->publishes([
            __DIR__.'/../migrations/' => database_path('migrations')
        ], 'migrations');
    }

    private function handleRoutes() {

        include __DIR__.'/../routes.php';
    }

    public function handleAssets(){

    }
}
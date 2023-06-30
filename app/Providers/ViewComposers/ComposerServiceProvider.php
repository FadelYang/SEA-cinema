<?php
 
namespace App\Providers\ViewComposers;

use App\Http\Controllers\HomeController;
use Illuminate\Support\ServiceProvider;
 
class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function boot()
    {
        // Using Closure based composers...
        view()->creator(['home', 'welcome', 'detail'], function ($view) {
            $movies = app(HomeController::class)->getMovieList();

            $view->with('movies', $movies); 
        });
    }
 
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
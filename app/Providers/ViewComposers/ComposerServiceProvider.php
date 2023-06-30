<?php
 
namespace App\Providers\ViewComposers;

use App\Http\Controllers\MovieController;
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
        view()->creator(['welcome', 'detail', 'recommendation'], function ($view) {
            $movies = app(MovieController::class)->getMovieList(true);

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
<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Category;
use App\Front;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        

        \PagSeguro\Library::initialize();
        \PagSeguro\Library::cmsVersion()->setName("glitty-store")->setRelease("1.0.0");
        \PagSeguro\Library::moduleVersion()->setName("glitty-store")->setRelease("1.0.0");
        \Illuminate\Support\Facades\Schema::defaultStringLength(191);
        \Blade::setEchoFormat('nl2br(e(%s))');

      
        view()->composer('*', function($view){
            $categoriesLayouts = Category::orderBy('position')->get();
            /*
            if(count(Front::all()) > 0){
                $front = Front::first()->get();
                $view->with('front', $front);
            }
            */
            $view->with('categoriesLayouts', $categoriesLayouts);
        });

    }
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Config;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Paginator::useBootstrap();
        Config::set(['page_title_end'=>' | صحتي', 'pagination_num'=>4,
            'type_admin_id'=>1, 'type_normal_id' => 2, 'type_doctor_id'=>3 ]);
        if(config('app.env') === 'production') {
            \URL::forceScheme('https');
        }
    }
}

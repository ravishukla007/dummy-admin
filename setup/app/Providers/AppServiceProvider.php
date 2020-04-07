<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Response;


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
        Response::macro('success', function ($message, $array=array()) {
            return Response::json([
                "success" => true,
                "message" => $message,
                "data" => $array
            ]);
        });

        Response::macro('fail', function ($message, $array=array()) {
            return Response::json([
                "success" => false,
                "message" => $message
            ]);
        });
    }
}

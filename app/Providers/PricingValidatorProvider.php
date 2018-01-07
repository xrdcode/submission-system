<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PricingValidatorProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('only_one', function ($attribute, $value, $parameters, $validator) {
            $user = User::where($attribute, "=", $value)->first();
            if($user) {
                return true;
            } else {
                return false;
            }
        });
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}

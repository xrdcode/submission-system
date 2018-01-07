<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Models\BaseModel\User;

class CustomValidationProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('is_registered', function ($attribute, $value, $parameters, $validator) {
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

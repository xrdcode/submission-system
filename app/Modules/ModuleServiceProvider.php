<?php

namespace App\Modules;

use Illuminate\Support\ServiceProvider;
use App\Models\BaseModel\Module;

class ModuleServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {


        try {
            $modules = Module::all();

            foreach ($modules as $m) {
                // Load the routes for each of the modules
                if(file_exists(__DIR__.'/'.$m->pathname.'/routes.php')) {
                    include __DIR__.'/'.$m->pathname.'/routes.php';
                }

                // Load the views
                if(is_dir(__DIR__.'/'.$m->pathname.'/Views')) {
                    $this->loadViewsFrom(__DIR__.'/'.$m->pathname.'/Views', $m->pathname);
                }
            }
        } catch (\Illuminate\Database\QueryException $ex) {
            $modules = config("module.modules");

            while (list(,$module) = each($modules)) {

                // Load the routes for each of the modules
                if(file_exists(__DIR__.'/'.$module.'/routes.php')) {
                    include __DIR__.'/'.$module.'/routes.php';
                }

                // Load the views
                if(is_dir(__DIR__.'/'.$module.'/Views')) {
                    $this->loadViewsFrom(__DIR__.'/'.$module.'/Views', $module);
                }


            }
        }




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

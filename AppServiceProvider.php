<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {

        /**
         * Inserts "selected" option attribute on loose equality.
         * @param string $expression A literal string of two params given to the directive. User
         * should call the directive with two values to be compared for equality.
         * @return string Code to be executed within the blade.
         */
        Blade::directive('selected', function($expression){
            list($a, $b) = explode(',', $expression);
            return '<?php echo (' . $a . ' == ' . $b . ') ? "selected" : ""; ?>';
        });

        /**
         * Creates option elements for a select. Does NOT work with multidensional arrays to
         * to produce optgroups (as the old Form::select() did).
         * @param array First param is an 'id' indexed array, as from $collection->pluck('name','id') OR
         * a collection of objects.
         * @param mixed Second param is the value to determine selection. [optional]
         * @param string Third param is the name of the object property you want displayed. [optional]
         * @return Returns a string of code to be executed at the point of insertion in template
         */
        Blade::directive('options', function($expression){
            $a = explode(',', $expression);
            $a1 = $a[0]; // array of objects or strings
            $a2 = isset($a[1]) ? $a[1] : 'false'; // search value
            $a3 = isset($a[2]) ? $a[2] : 'false'; // name field

            $st = '<?php
                $_name_field = ' . $a3 . ' ?: "name";
                foreach(' . $a1 . ' as $idx => $objOrStr){
                    if(is_string($objOrStr)){
                        $sel = $idx == ' . $a2 . ' ? "selected" : "";
                        echo \'<option value="\' . $idx . \'" \' . $sel . \'>\' . $objOrStr . "</option>\n";
                    } else {
                        $sel = $objOrStr->id == ' . $a2 . ' ? "selected" : "";
                        echo \'<option value="\' . $objOrStr->id . \'" \' . $sel . \'>\' . $objOrStr->$_name_field . "</option>\n";
                    }
                }
            ?>';
            return $st;

        });
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
}

<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use DB;

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
        Carbon::setLocale('id');
        Validator::extend('max_mb', function($attribute, $value, $parameters, $validator) {
            $validator->requireParameterCount(1, $parameters, 'max_mb');

            if ($value instanceof UploadedFile && ! $value->isValid()) {
                return false;
            }

            // If call getSize()/1024/1024 on $value here it'll be numeric and not
            // get divided by 1024 once in the Validator::getSize() method.

            $megabytes = $value->getSize() / 1024 / 1024;

            return $megabytes <= $parameters[0];
        });
        Validator::replacer('max_mb', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':' . $rule, $parameters[0], $message);
        });

        Validator::extend('iunique', function ($attribute, $value, $parameters, $validator) {
            $query = DB::table($parameters[0]);
            $column = $query->getGrammar()->wrap($parameters[1]);
            $query->whereRaw("lower({$column}) = lower(?)", [$value]);
            if(isset($parameters[2])){
                $query->where('id', '!=', $parameters[2]);
            }
            return ! $query->count();
        });
        Validator::replacer('iunique', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':' . $rule, $parameters[0], $message);
        });
    }
}

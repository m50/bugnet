<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;
use App\Providers\TelescopeServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extend('can', function ($attribute, $value, $parameters) {
            [$ability, $arguments] = $parameters;
            return auth()->user()->can($ability, $arguments);
        });
        Validator::replacer('can', function ($message, $attribute, $rule, $parameters) {
            return __('validation.can', ['attribute' => $attribute]);
        });

        Validator::extend('contain_number', function ($attribute, $value, $parameters) {
            return preg_match('/[0-9]/', $value);
        });
        Validator::replacer('contain_number', function ($message, $attribute, $rule, $parameters) {
            return __('validation.password.number', ['attribute' => $attribute]);
        });
        Validator::extend('contain_upper_case', function ($attribute, $value, $parameters) {
            return preg_match('/[A-Z]/', $value);
        });
        Validator::replacer('contain_upper_case', function ($message, $attribute, $rule, $parameters) {
            return __('validation.password.upper_case', ['attribute' => $attribute]);
        });
        Validator::extend('contain_lower_case', function ($attribute, $value, $parameters) {
            return preg_match('/[a-z]/', $value);
        });
        Validator::replacer('contain_lower_case', function ($message, $attribute, $rule, $parameters) {
            return __('validation.password.lower_case', ['attribute' => $attribute]);
        });
        Validator::extend('contain_symbol', function ($attribute, $value, $parameters) {
            return preg_match('/[!@$%&<>?\[\]{}]/', $value);
        });
        Validator::replacer('contain_symbol', function ($message, $attribute, $rule, $parameters) {
            return __('validation.password.symbol', ['attribute' => $attribute]);
        });
    }
}

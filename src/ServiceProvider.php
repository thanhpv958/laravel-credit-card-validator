<?php
namespace Rap2hpoutre\LaravelCreditCardValidator;

use Illuminate\Support\ServiceProvider as BaseServiceProvider;
use Rap2hpoutre\LaravelCreditCardValidator\CreditCard;

class ServiceProvider extends BaseServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // card number
        \Validator::extend('ccn', function($attribute, $value, $parameters, $validator) {
            return CreditCard::validCreditCard($value)['valid'];
        });

        // year/month
        \Validator::extend('ccd', function($attribute, $value, $parameters, $validator) {
            $value = explode('/', $value);

            return CreditCard::validDate(strlen($value[0]) == 2 ? (2000+$value[0]) : $value[0], $value[1]);
        });

        // month
        \Validator::extend('ccdm', function($attribute, $value, $parameters, $validator) {
            return CreditCard::validMonth($value);
        });

        // year
        \Validator::extend('ccdy', function($attribute, $value, $parameters, $validator) {
            $value = strlen($value) == 2 ? (2000+$value) : $value;

            return CreditCard::validYear($value);
        });

        // card cvc
        \Validator::extend('cvc', function($attribute, $value, $parameters, $validator) {
            return ctype_digit($value) && (strlen($value) == 3 || strlen($value) == 4);
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

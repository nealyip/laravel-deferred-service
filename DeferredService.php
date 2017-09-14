<?php
/**
 * Created by PhpStorm.
 * User: neal.yip
 * Date: 14/9/2017
 * Time: 18:25
 */

namespace App\Providers;


use Illuminate\Support\ServiceProvider;

/**
 * Class DeferService
 *
 *
 * Your compiled manifest file is already compiled by framework.
 *
 * On the first time when Laravel build the application (and resolves all of services providers in IoC)
 * it writes to cached file named services.php (that is, the manifest file, placed in: bootstrap/cache/services.php).
 * So, if you clear the compiled via php artisan clear-compiled command it should force framework to rebuild
 * the manifest file and you could to note that provides method is called. On the next calls/requests provides
 * method is not called anymore.
 *
 *
 * To test
 * 1) php artisan clear-compiled
 * 2) browse web eg, http://localhost
 * 3) provides() is called
 * 4) cached
 * 5) somewhere call resolve(C::class) or Dependency injection
 * 6) register() is called
 *
 * 7) browse web again eg, http://localhost
 * 8) provides is no longer called
 * 9) somewhere call resolve(C::class) or Dependency injection
 * 10) register() is called
 *
 * 11) browse web again eg, http://localhost
 * 12) never call resolve(C::class) or Dependency injection
 * 13) register() is never called
 *
 * comparing to defer = false;
 * every time register() will be called
 * @package App\Providers
 */
class DeferredService extends ServiceProvider
{

    protected $defer = true;

    public function register()
    {
        $this->app->singleton(C::class, B::class);
    }

    public function provides()
    {
        $x = 1;
        return [
            C::class
        ];
    }

}

interface C
{
    public function c();
}

class B implements C
{
    public function c()
    {
        $i = 1;
    }
}
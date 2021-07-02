<?php

namespace Zbanx\Kit\Providers;

use Illuminate\Support\ServiceProvider;
use Zbanx\Kit\Providers\Macros\BuilderMacros;
use Zbanx\Kit\Providers\Macros\CollectionMacros;
use Zbanx\Kit\Providers\Macros\CommandMacros;

class MacrosServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        (new BuilderMacros)();
        (new CommandMacros)();
        (new CollectionMacros)();
    }
}

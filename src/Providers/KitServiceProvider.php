<?php


namespace Zbanx\Kit\Providers;

use Illuminate\Support\ServiceProvider;

class KitServiceProvider extends ServiceProvider
{
    public function boot(): void
    {
        $this->registerPublishing();
    }

    public function register(): void
    {
        $this->app->register(MacrosServiceProvider::class);
    }

    private function registerPublishing()
    {
        if ($this->app->runningInConsole()) {
            //发布 phpstorm meat 文件到项目中
            $this->publishes([
                __DIR__ . '/../../.phpstorm.meta.php' => base_path('.phpstorm.meta.php'),
            ]);
        }
    }


}

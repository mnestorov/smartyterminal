<?php

namespace SmartyStudio\SmartyTerminal;

use Illuminate\Http\Request;
use Illuminate\Routing\Router;
use Illuminate\Support\Arr;
use Illuminate\Support\ServiceProvider;
use SmartyStudio\SmartyTerminal\Console\Application;
use SmartyStudio\SmartyTerminal\Console\Kernel;

class TerminalServiceProvider extends ServiceProvider
{
    /**
     * Package controller namespace.
     *
     * @var string
     */
    protected string $namespace = 'SmartyStudio\SmartyTerminal\Http\Controllers';

    /**
     * Bootstrap any application services.
     *
     * @param Request $request
     * @param Router $router
     */
    public function boot(Request $request, Router $router)
    {
        $config = $this->app['config']['terminal'];
        if ($this->allowWhiteList($request, $config)) {
            $this->loadViewsFrom(__DIR__ . '/resources/views', 'terminal');

            // Routes
            if (!$this->app->routesAreCached()) {
                $router->group(array_merge([
                    'namespace' => $this->namespace,
                ], Arr::get($config, 'route', [])), function () {
                    require __DIR__ . '/routes/web.php';
                });
            }
        }

        // Publishing all the necessary configuration files
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/config/terminal.php' => config_path('terminal.php'),
                __DIR__ . '/resources/views' => base_path('resources/views/vendor/smartystudio/smartyterminal'),
                __DIR__ . '/resources/assets/dist' => public_path('vendor/smartystudio/smartyterminal'),
            ], 'smartyterminal');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/config/terminal.php', 'terminal');

        $this->app->bind(Application::class, function ($app) {
            $config = $app['config']['terminal'];
            $artisan = new Application($app, $app['events'], $app->version());

            return $artisan->resolveCommands($config['commands']);
        });

        $this->app->bind(Kernel::class, function ($app) {
            $config = $app['config']['terminal'];

            return new Kernel($app[Application::class], array_merge($config, [
                'basePath' => $app->basePath(),
                'environment' => $app->environment(),
                'version' => $app->version(),
                'endpoint' => $app['url']->route(Arr::get($config, 'route.as') . 'endpoint'),
            ]));
        });
    }

    /**
     * @param Request $request
     * @param $config
     * @return bool
     */
    private function allowWhiteList(Request $request, $config): bool
    {
        return in_array($request->getClientIp(), Arr::get($config, 'whitelists', []), true) || Arr::get($config, 'enabled');
    }
}

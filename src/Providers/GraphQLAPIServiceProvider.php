<?php

namespace Webkul\GraphQLAPI\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Illuminate\Support\ServiceProvider;
use Webkul\GraphQLAPI\BagistoGraphql;
use Webkul\GraphQLAPI\Console\Commands\Install as InstallGraphQL;
use Webkul\GraphQLAPI\Facades\BagistoGraphql as BagistoGraphqlFacade;
use Webkul\GraphQLAPI\Http\Middleware\CurrencyMiddleware;
use Webkul\GraphQLAPI\Http\Middleware\LocaleMiddleware;

class GraphQLAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot(Router $router)
    {
        include __DIR__.'/../Http/helpers.php';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'bagisto_graphql');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bagisto_graphql');

        $this->overrideModels();

        $this->publishesDefault();

        $this->app->register(ModuleServiceProvider::class);

        /* aliases */
        $router->aliasMiddleware('locale', LocaleMiddleware::class);

        $router->aliasMiddleware('currency', CurrencyMiddleware::class);

        if (request()->hasHeader('authorization')) {
            $headerValue = explode('Bearer ', request()->header('authorization'));

            if (count($headerValue) == 2) {
                request()->merge(['token' => end($headerValue)]);
            }
        }
    }

    /**
     * Override the existing models
     */
    public function overrideModels()
    {
        // Admin Models
        $this->app->concord->registerModel(
            \Webkul\User\Contracts\Admin::class,
            \Webkul\GraphQLAPI\Models\Admin\Admin::class
        );

        // Customer Models
        $this->app->concord->registerModel(
            \Webkul\Customer\Contracts\Customer::class,
            \Webkul\GraphQLAPI\Models\Customer\Customer::class
        );

        // Customer Models
        $this->app->concord->registerModel(
            \Webkul\CartRule\Contracts\CartRule::class,
            \Webkul\GraphQLAPI\Models\CartRule\CartRule::class
        );
    }

    /**
     * Publish all Default theme page.
     *
     * @return void
     */
    protected function publishesDefault()
    {
        $this->publishes([
            __DIR__.'/../Config/lighthouse.php' => config_path('lighthouse.php'),
        ], ['graphql-api-lighthouse']);
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands();

        $this->registerFacades();

        $this->registerConfig();
    }

    /**
     * Register the console commands of this package.
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallGraphQL::class,
            ]);
        }
    }

    /**
     * Register Bouncer as a singleton.
     *
     * @return void
     */
    protected function registerFacades()
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('bagisto_graphql', BagistoGraphqlFacade::class);

        $this->app->singleton('bagisto_graphql', function () {
            return app()->make(BagistoGraphql::class);
        });
    }

    /**
     * Register package config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/menu.php',
            'menu.admin'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/acl.php',
            'acl'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/system.php',
            'core'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/auth/guards.php',
            'auth.guards'
        );

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/auth/providers.php',
            'auth.providers'
        );

    }
}

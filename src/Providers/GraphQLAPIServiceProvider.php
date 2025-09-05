<?php

namespace Webkul\GraphQLAPI\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Webkul\GraphQLAPI\BagistoGraphql;
use Webkul\GraphQLAPI\Console\Commands\Install;
use Webkul\GraphQLAPI\Facades\BagistoGraphql as BagistoGraphqlFacade;

class GraphQLAPIServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
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
            $this->commands(Install::class);
        }
    }

    /**
     * Register facades.
     */
    protected function registerFacades(): void
    {
        $loader = AliasLoader::getInstance();

        $loader->alias('bagisto_graphql', BagistoGraphqlFacade::class);

        $this->app->singleton('bagisto_graphql', function () {
            return app()->make(BagistoGraphql::class);
        });
    }

    /**
     * Register package config.
     */
    protected function registerConfig(): void
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

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/logging.php',
            'logging.channels'
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        include __DIR__.'/../Http/helpers.php';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'bagisto_graphql');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bagisto_graphql');

        $this->app->register(ModuleServiceProvider::class);

        $this->app->register(EventServiceProvider::class);

        $this->overrideCoreClasses();

        $this->publishesDefault();
    }

    /**
     * Override the core classes
     */
    protected function overrideCoreClasses(): void
    {
        $this->app->concord->registerModel(
            \Webkul\User\Contracts\Admin::class,
            \Webkul\GraphQLAPI\Models\Admin\Admin::class
        );

        $this->app->concord->registerModel(
            \Webkul\Customer\Contracts\Customer::class,
            \Webkul\GraphQLAPI\Models\Customer\Customer::class
        );

        $this->app->concord->registerModel(
            \Webkul\CartRule\Contracts\CartRule::class,
            \Webkul\GraphQLAPI\Models\CartRule\CartRule::class
        );

        $this->app->bind(
            \Webkul\Shop\Http\Controllers\API\WishlistController::class, \Webkul\GraphQLAPI\Http\Controllers\Shop\API\WishlistController::class
        );
    }

    /**
     * Publish the default configuration files.
     */
    protected function publishesDefault(): void
    {
        $this->publishes([
            __DIR__.'/../Config/lighthouse.php' => config_path('lighthouse.php'),
        ], ['graphql-api-lighthouse']);

        $this->publishes([
            __DIR__.'/../Config/graphiql.php' => config_path('graphiql.php'),
        ], ['graphql-api-graphiql']);
    }
}

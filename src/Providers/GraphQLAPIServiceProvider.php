<?php

namespace Webkul\GraphQLAPI\Providers;

use Illuminate\Foundation\AliasLoader;
use Illuminate\Support\ServiceProvider;
use Webkul\Admin\Http\Controllers\Customers\Customer\WishlistController as WishlistControllerAdminBase;
use Webkul\Checkout\Cart as BaseCart;
use Webkul\GraphQLAPI\BagistoGraphql;
use Webkul\GraphQLAPI\Cart;
use Webkul\GraphQLAPI\Console\Commands\Install as InstallGraphQL;
use Webkul\GraphQLAPI\Facades\BagistoGraphql as BagistoGraphqlFacade;
use Webkul\GraphQLAPI\Http\Controllers\Admin\Customers\Customer\WishlistController as WishlistControllerAdmin;
use Webkul\GraphQLAPI\Http\Controllers\Shop\API\CompareController;
use Webkul\GraphQLAPI\Http\Controllers\Shop\API\ReviewController;
use Webkul\GraphQLAPI\Http\Controllers\Shop\API\WishlistController;
use Webkul\Shop\Http\Controllers\API\CompareController as CompareControllerBase;
use Webkul\Shop\Http\Controllers\API\ReviewController as ReviewControllerBase;
use Webkul\Shop\Http\Controllers\API\WishlistController as WishlistControllerBase;

class GraphQLAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     *
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        include __DIR__.'/../Http/helpers.php';

        $this->loadRoutesFrom(__DIR__.'/../Routes/web.php');

        $this->loadMigrationsFrom(__DIR__.'/../Database/Migrations');

        $this->loadTranslationsFrom(__DIR__.'/../Resources/lang', 'bagisto_graphql');

        $this->loadViewsFrom(__DIR__.'/../Resources/views', 'bagisto_graphql');

        $this->overrideModels();

        $this->publishesDefault();

        $this->app->register(ModuleServiceProvider::class);
        $this->app->register(EventServiceProvider::class);

        $this->app->bind(CompareControllerBase::class, CompareController::class);

        $this->app->bind(WishlistControllerBase::class, WishlistController::class);

        $this->app->bind(ReviewControllerBase::class, ReviewController::class);

        $this->app->bind(WishlistControllerAdminBase::class, WishlistControllerAdmin::class);

        $this->app->bind(BaseCart::class, Cart::class);
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

        $this->publishes([
            __DIR__.'/../Config/graphiql.php' => config_path('graphiql.php'),
        ], ['graphql-api-graphiql']);
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

        $this->mergeConfigFrom(
            dirname(__DIR__).'/Config/logging.php',
            'logging.channels'
        );
    }
}

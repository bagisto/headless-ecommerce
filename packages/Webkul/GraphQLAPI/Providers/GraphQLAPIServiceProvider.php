<?php

namespace Webkul\GraphQLAPI\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Webkul\Checkout\Facades\Cart;
use Webkul\GraphQLAPI\BagistoGraphql;
use Webkul\GraphQLAPI\Facades\BagistoGraphql as BagistoGraphqlFacade;
use Webkul\GraphQLAPI\Console\Commands\Install;

class GraphQLAPIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function boot()
    {
        include __DIR__ . '/../Http/helpers.php';

        $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'bagisto_graphql');

        $this->loadViewsFrom(__DIR__ . '/../Resources/views', 'bagisto_graphql');

        //model observer for admin user of Bagisto
        $this->overrideModels();
    }

    /**
     * Override the existing models
     */
    public function overrideModels()
    {
        // Category Model
        $this->app->concord->registerModel(\Webkul\Category\Models\Category::class, \Webkul\GraphQLAPI\Models\Catalog\Category::class);

        // CategoryTranslation Model
        $this->app->concord->registerModel(\Webkul\Category\Models\CategoryTranslation::class, \Webkul\GraphQLAPI\Models\Catalog\CategoryTranslation::class);

        // Catalog Product Models
        $this->app->concord->registerModel(\Webkul\Product\Contracts\Product::class, \Webkul\GraphQLAPI\Models\Catalog\Product::class);
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
    }

    /**
     * Register the console commands of this package
     *
     * @return void
     */
    protected function registerCommands(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Install::class
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
        
        $loader->alias('cart', Cart::class);

        $this->app->singleton('cart', function () {
            return new cart();
        });

        $this->app->bind('cart', 'Webkul\GraphQLAPI\Cart');
    }
}

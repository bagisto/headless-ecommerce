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
        // Admin Models
        $this->app->concord->registerModel(\Webkul\User\Contracts\Admin::class, \Webkul\GraphQLAPI\Models\User\Admin::class);

        // CurrencyExchangeRate Models
        $this->app->concord->registerModel(\Webkul\Core\Contracts\CurrencyExchangeRate::class, \Webkul\GraphQLAPI\Models\Setting\CurrencyExchangeRate::class);

        // Slider Models
        $this->app->concord->registerModel(\Webkul\Core\Models\Slider::class, \Webkul\GraphQLAPI\Models\Setting\Slider::class);

        // Category Model
        $this->app->concord->registerModel(\Webkul\Category\Models\Category::class, \Webkul\GraphQLAPI\Models\Catalog\Category::class);

        // CategoryTranslation Model
        $this->app->concord->registerModel(\Webkul\Category\Models\CategoryTranslation::class, \Webkul\GraphQLAPI\Models\Catalog\CategoryTranslation::class);

        // CatalogRule Models
        $this->app->concord->registerModel(\Webkul\CatalogRule\Contracts\CatalogRule::class, \Webkul\GraphQLAPI\Models\CatalogRule\CatalogRule::class);

        // CatalogRuleProduct Models
        $this->app->concord->registerModel(\Webkul\CatalogRule\Contracts\CatalogRuleProduct::class, \Webkul\GraphQLAPI\Models\CatalogRule\CatalogRuleProduct::class);

        // Country Models
        $this->app->concord->registerModel(\Webkul\Core\Contracts\Country::class, \Webkul\GraphQLAPI\Models\Core\Country::class);

        // CountryState Models
        $this->app->concord->registerModel(\Webkul\Core\Contracts\CountryTranslation::class, \Webkul\GraphQLAPI\Models\Core\CountryTranslation::class);

        // CartRule Coupon Models
        $this->app->concord->registerModel(\Webkul\CartRule\Contracts\CartRuleCoupon::class, \Webkul\GraphQLAPI\Models\CartRule\CartRuleCoupon::class);

        // BookingProduct Coupon Models
        $this->app->concord->registerModel(\Webkul\BookingProduct\Contracts\BookingProduct::class, \Webkul\GraphQLAPI\Models\BookingProduct\BookingProduct::class);

        // Compare Product Models
        $this->app->concord->registerModel(\Webkul\Velocity\Contracts\VelocityCustomerCompareProduct::class, \Webkul\GraphQLAPI\Models\Velocity\VelocityCustomerCompareProduct::class);

        // Compare Product Models
        $this->app->concord->registerModel(\Webkul\Customer\Contracts\Wishlist::class, \Webkul\GraphQLAPI\Models\Customer\Wishlist::class);

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

<?php

namespace Webkul\GraphQLAPI\Http\Middleware;

use Closure;
use Webkul\Core\Repositories\CurrencyRepository;

class CurrencyMiddleware
{
    /**
     * Create a middleware instance.
     *
     * @param  \Webkul\Core\Repositories\CurrencyRepository $locale
     * @return void
     */
    public function __construct(protected CurrencyRepository $currencyRepository)
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $currencyCode = $request->header('x-currency');

        if ($currencyCode && $this->currencyRepository->findOneByField('code', $currencyCode)) {
            core()->setCurrentCurrency($currencyCode);

            return $next($request);
        }

        core()->setCurrentCurrency(core()->getChannelBaseCurrencyCode());

        return $next($request);
    }
}

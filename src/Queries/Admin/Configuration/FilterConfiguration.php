<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Configuration;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Str;
use Nuwave\Lighthouse\Exceptions\AuthenticationException;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class FilterConfiguration extends BaseFilter
{
    /**
     * Filter the query by the given input.
     */
    public function __invoke(Builder $query, array $input): Builder
    {
        $this->ensureFrontendRequestWasSecured();

        $query = $this->applyFilter($query, Arr::only($input, ['channel_code', 'locale_code']));

        return $this->applyLikeFilter($query, Arr::only($input, ['code']));
    }

    /**
     * Get single record by the given args.
     */
    public function get(mixed $rootvalue, array $args): ?string
    {
        $this->ensureFrontendRequestWasSecured();

        return core()->getConfigData($args['code']);
    }

    /**
     * Ensure that the frontend request was secured with the correct API key.
     *
     * @throws \Illuminate\Auth\AuthenticationException
     */
    protected function ensureFrontendRequestWasSecured(): void
    {
        $headerKey = Request::header('x-app-secret-key');

        $envKey = Str::of(env('APP_SECRET_KEY'))->replace('base64:', '')->toString();

        if (
            is_null($headerKey)
            || $headerKey !== $envKey
        ) {
            throw new AuthenticationException('Invalid or missing app secret key.');
        }
    }
}

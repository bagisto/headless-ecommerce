<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Nuwave\Lighthouse\Support\Contracts\GraphQLContext;
use Webkul\GraphQLAPI\Queries\BaseFilter;

class ThemeContent extends BaseFilter
{
    /**
     * filter the data .
     *
     * @param  object  $query
     * @param  array  $input
     * @return object
     */
    public function getThemeTranslations(mixed $rootValue, array $args, GraphQLContext $context)
    {
        if (
            $rootValue->type == 'product_carousel'
            || $rootValue->type == 'category_carousel'
        ) {

            if (isset($rootValue->options['title'])) {
                $options['title'] = $rootValue->options['title'];
            }

            $options['filters'] = [];

            $i = 0;

            foreach ($rootValue->options['filters'] as $key => $value) {
                $options['filters'][$i]['key'] = $key;
                $options['filters'][$i]['value'] = $value;

                $i++;
            }

            $rootValue->options = $options;
        }

        return $rootValue->translations;
    }
}

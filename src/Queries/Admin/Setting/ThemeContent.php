<?php

namespace Webkul\GraphQLAPI\Queries\Admin\Setting;

use Webkul\GraphQLAPI\Queries\BaseFilter;

class ThemeContent extends BaseFilter
{
    /**
     * Filter the query by the given input.
     *
     * @return \Webkul\Theme\Contracts\ThemeCustomizationTranslation
     */
    public function getThemeTranslations(mixed $theme)
    {
        if (
            $theme->type == 'product_carousel'
            || $theme->type == 'category_carousel'
        ) {

            if (isset($theme->options['title'])) {
                $options['title'] = $theme->options['title'];
            }

            $options['filters'] = [];

            $i = 0;

            foreach ($theme->options['filters'] as $key => $value) {
                $options['filters'][$i]['key'] = $key;
                $options['filters'][$i]['value'] = $value;

                $i++;
            }

            $theme->options = $options;
        }

        return $theme->translations;
    }
}

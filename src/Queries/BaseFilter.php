<?php

namespace Webkul\GraphQLAPI\Queries;

class BaseFilter
{
    /**
     * Validate the data having not null in array.
     *
     * @param  arr  $args
     * @return array
     */
    public function getFilterParams($args)
    {
        $arguments = [];

        foreach ($args as $keys => $arg) {

            $arguments[$keys] = $arg;
        }

        return $arguments;
    }

    /**
     * Split the name into firstname and lastname
     *
     * @param  string  $name
     * @return array
     */
    public function nameSplitter($name)
    {
        $nameChanger = explode(' ', $name);

        $result['firstname'] = $nameChanger[0];

        unset($nameChanger[0]);

        $result['lastname'] = implode(' ', $nameChanger);

        return $result;
    }
}

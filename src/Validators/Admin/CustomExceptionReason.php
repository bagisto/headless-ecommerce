<?php

namespace Webkul\GraphQLAPI\Validators\Admin;

use GraphQL\Error\ClientAware;

class CustomExceptionReason extends Exception implements ClientAware
{
    /**
     * @param string $message — [optional] The Exception message to throw.
     *
     * @return void
     */
    
    public function __construct(
        string $message,
        protected string $reason
    ) {
        parent::__construct($message);
    }

    /**
     * Returns true when exception message is safe to be displayed to a client.
     *
     * @api
     * @return bool
     */
    public function isClientSafe(): bool
    {
        return true;
    }
}

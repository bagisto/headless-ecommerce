<?php

namespace Webkul\GraphQLAPI\Validators\Admin;

use Exception;
use GraphQL\Error\ClientAware;

class CustomExceptionReason extends Exception implements ClientAware
{
    /**
    * @var @string
    */
    protected $reason;

    public function __construct(
        string $message,
        string $reason
    )
    {
        parent::__construct($message);

        $this->reason = $reason;
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

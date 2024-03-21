<?php

namespace Webkul\GraphQLAPI\Validators\Customer;

use Exception;
use GraphQL\Error\ClientAware;

class CustomException extends Exception implements ClientAware
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

    /**
     * Returns string describing a category of the error.
     *
     * Value "graphql" is reserved for errors produced by query parsing or validation, do not use it.
     *
     * @api
     * @return string
     */
    public function getCategory(): string
    {
        return 'customerLogin';
    }

    /**
     * Return the content that is put in the "extensions" part
     * of the returned error.
     *
     * @return array
     */
    public function extensionsContent(): array
    {
        return [
            'some'   => 'Customer Login Attempt',
            'reason' => $this->reason,
        ];
    }
}

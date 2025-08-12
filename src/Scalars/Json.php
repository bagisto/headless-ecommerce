<?php

namespace Webkul\GraphQLAPI\Scalars;

use GraphQL\Type\Definition\ScalarType;

class JSON extends ScalarType
{
    /**
     * Name of the scalar type.
     */
    public string $name = 'JSON';

    /**
     * Serialize the value for sending to the client.
     * Here we return the value as-is, assuming it's already a valid JSON-serializable PHP value.
     */
    public function serialize($value)
    {
        return $value;
    }

    /**
     * Parse a value received from the client (e.g., from a GraphQL variable).
     * This method accepts PHP input and returns it unchanged.
     */
    public function parseValue($value)
    {
        return $value;
    }

    /**
     * Parse a literal value from the GraphQL query AST.
     * This converts the literal node into a PHP array or object using JSON encoding/decoding.
     */
    public function parseLiteral($valueNode, ?array $variables = null)
    {
        return json_decode(json_encode($valueNode), true);
    }
}

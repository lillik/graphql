<?php

declare(strict_types=1);

namespace App\GraphQL\Type;

use DateTime;
use DateTimeInterface;
use Exception;
use GraphQL\Language\AST\Node;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;

class DateTimeType extends ScalarType
{
    public string $name = 'DateTime';
    /**
     * @inheritDoc
     */
    public function serialize($value)
    {
        return $value instanceof DateTime ? $value->format(DateTimeInterface::ATOM) : null;
    }

    /**
     * @inheritDoc
     * @throws \DateMalformedStringException
     */
    public function parseValue($value)
    {
        // Conversie string -> DateTime
        return new DateTime($value);
    }

    /**
     * @inheritDoc
     * @throws \DateMalformedStringException
     */
    public function parseLiteral(Node $valueNode, ?array $variables = null)
    {
        if (!$valueNode instanceof StringValueNode) {
            throw new Exception("DateTime should be a string in ISO 8601 format");
        }
        return new DateTime($valueNode->value);
    }
}

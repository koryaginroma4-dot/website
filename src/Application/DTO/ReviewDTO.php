<?php

declare(strict_types=1);

namespace App\Application\DTO;

use InvalidArgumentException;

final class ReviewDTO
{
    public function __construct(
        public readonly string $authorName,
        public readonly ?string $authorLocation,
        public readonly string $comment,
    ) {
    }

    /**
     * @param array<string, mixed> $requestData
     */
    public static function fromRequestData(array $requestData): self
    {
        return new self(
            authorName: self::requiredString($requestData, 'authorName'),
            authorLocation: self::nullableString($requestData, 'authorLocation'),
            comment: self::requiredString($requestData, 'comment'),
        );
    }

    /**
     * @param array<string, mixed> $requestData
     */
    private static function requiredString(array $requestData, string $field): string
    {
        $value = self::nullableString($requestData, $field);

        if ($value === null) {
            throw new InvalidArgumentException(sprintf('Field "%s" is required.', $field));
        }

        return $value;
    }

    /**
     * @param array<string, mixed> $requestData
     */
    private static function nullableString(array $requestData, string $field): ?string
    {
        if (!array_key_exists($field, $requestData)) {
            return null;
        }

        $rawValue = $requestData[$field];

        if (!is_scalar($rawValue) && $rawValue !== null) {
            throw new InvalidArgumentException(sprintf('Field "%s" has an invalid type.', $field));
        }

        $value = trim((string) $rawValue);

        return $value === '' ? null : $value;
    }
}

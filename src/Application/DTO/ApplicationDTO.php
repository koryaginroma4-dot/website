<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Enum\FinishWantedType;
use App\Domain\Enum\FireplaceUnitType;
use App\Domain\Enum\HomeType;
use InvalidArgumentException;

final class ApplicationDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
        public readonly ?string $howDidYourHearAboutUs,
        public readonly ?string $homeType,
        public readonly ?string $spaceSetup,
        public readonly ?string $fireplaceUnit,
        public readonly ?string $finishWanted,
        public readonly ?string $spacePhoto,
        public readonly string $additionalNotes,
    ) {
    }

    /**
     * @param array<string, mixed> $requestData
     */
    public static function fromRequestData(array $requestData, ?string $spacePhoto): self
    {
        return new self(
            name: self::requiredString($requestData, 'name'),
            email: self::requiredString($requestData, 'email'),
            phone: self::requiredString($requestData, 'phone'),
            city: self::requiredString($requestData, 'city'),
            howDidYourHearAboutUs: self::nullableString($requestData, 'howDidYourHearAboutUs'),
            homeType: self::nullableEnumValue($requestData, 'homeType', HomeType::values()),
            spaceSetup: self::nullableString($requestData, 'spaceSetup'),
            fireplaceUnit: self::nullableEnumValue($requestData, 'fireplaceUnit', FireplaceUnitType::values()),
            finishWanted: self::nullableEnumValue($requestData, 'finishWanted', FinishWantedType::values()),
            spacePhoto: $spacePhoto,
            additionalNotes: self::requiredString($requestData, 'additionalNotes'),
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

    /**
     * @param array<string, mixed> $requestData
     * @param array<string> $allowedValues
     */
    private static function nullableEnumValue(array $requestData, string $field, array $allowedValues): ?string
    {
        $value = self::nullableString($requestData, $field);

        if ($value === null) {
            return null;
        }

        if (!in_array($value, $allowedValues, true)) {
            throw new InvalidArgumentException(sprintf('Field "%s" has an invalid value.', $field));
        }

        return $value;
    }

}

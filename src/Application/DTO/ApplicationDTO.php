<?php

declare(strict_types=1);

namespace App\Application\DTO;

use App\Domain\Enum\FinishWantedType;
use App\Domain\Enum\FireplaceUnitType;
use App\Domain\Enum\HomeType;
use App\Domain\Enum\ProjectType;
use InvalidArgumentException;

final class ApplicationDTO
{
    private const BASEMENT_DETAILS_FIELDS = [
        'square_feet',
        'ceiling_height',
        'unfinished_or_finished',
        'rough_ins',
        'kitchen_or_bar',
        'bedrooms',
        'bathrooms',
        'laundry_area',
        'separate_entrance',
        'permits_needed',
        'water_damage',
        'insulation_needed',
        'flooring_type',
        'timeline',
        'budget',
    ];

    private const BATHROOM_DETAILS_FIELDS = [
        'bathroom_type',
        'size',
        'full_remodel',
        'layout_changes',
        'tub_or_shower',
        'glass_door',
        'tile_scope',
        'waterproofing',
        'fixtures_supplied',
        'current_issues',
        'timeline',
        'budget',
    ];

    private const BATHROOM_MULTI_VALUE_FIELDS = [
        'current_issues',
    ];

    private const KITCHEN_DETAILS_FIELDS = [
        'kitchen_size',
        'full_or_partial',
        'layout_changes',
        'new_cabinets',
        'countertops',
        'backsplash',
        'island',
        'appliances',
        'electrical_changes',
        'plumbing_changes',
        'flooring',
        'materials_supplied',
        'timeline',
        'budget',
    ];

    /**
     * @param array<string, mixed> $basementDetails
     * @param array<string, mixed> $bathroomDetails
     * @param array<string, mixed> $kitchenDetails
     */
    public function __construct(
        public readonly string $name,
        public readonly string $email,
        public readonly string $phone,
        public readonly string $city,
        public readonly string $projectType,
        public readonly ?string $preferredStartTime,
        public readonly ?string $budgetRange,
        public readonly ?bool $ownsProperty,
        public readonly ?string $howDidYourHearAboutUs,
        public readonly ?string $homeType,
        public readonly ?string $spaceSetup,
        public readonly ?string $fireplaceUnit,
        public readonly ?string $finishWanted,
        public readonly ?string $spacePhoto,
        public readonly string $additionalNotes,
        public readonly array $basementDetails,
        public readonly array $bathroomDetails,
        public readonly array $kitchenDetails,
    ) {
    }

    /**
     * @param array<string, mixed> $requestData
     */
    public static function fromRequestData(array $requestData, ?string $spacePhoto): self
    {
        $projectType = self::requiredEnumValue($requestData, 'projectType', ProjectType::values());

        return new self(
            name: self::requiredString($requestData, 'name'),
            email: self::requiredString($requestData, 'email'),
            phone: self::requiredString($requestData, 'phone'),
            city: self::requiredString($requestData, 'city'),
            projectType: $projectType,
            preferredStartTime: self::nullableString($requestData, 'preferredStartTime'),
            budgetRange: self::nullableString($requestData, 'budgetRange'),
            ownsProperty: self::nullableBoolean($requestData, 'ownsProperty'),
            howDidYourHearAboutUs: $projectType === ProjectType::MediaWall->value
                ? self::nullableString($requestData, 'howDidYourHearAboutUs')
                : null,
            homeType: $projectType === ProjectType::MediaWall->value
                ? self::nullableEnumValue($requestData, 'homeType', HomeType::values())
                : null,
            spaceSetup: $projectType === ProjectType::MediaWall->value
                ? self::nullableString($requestData, 'spaceSetup')
                : null,
            fireplaceUnit: $projectType === ProjectType::MediaWall->value
                ? self::nullableEnumValue($requestData, 'fireplaceUnit', FireplaceUnitType::values())
                : null,
            finishWanted: $projectType === ProjectType::MediaWall->value
                ? self::nullableEnumValue($requestData, 'finishWanted', FinishWantedType::values())
                : null,
            spacePhoto: $spacePhoto,
            additionalNotes: self::requiredString($requestData, 'additionalNotes'),
            basementDetails: $projectType === ProjectType::BasementRenovation->value
                ? self::collectDetails($requestData, self::BASEMENT_DETAILS_FIELDS)
                : [],
            bathroomDetails: $projectType === ProjectType::BathroomRenovation->value
                ? self::collectDetails(
                    $requestData,
                    self::BATHROOM_DETAILS_FIELDS,
                    self::BATHROOM_MULTI_VALUE_FIELDS,
                )
                : [],
            kitchenDetails: $projectType === ProjectType::KitchenRenovation->value
                ? self::collectDetails($requestData, self::KITCHEN_DETAILS_FIELDS)
                : [],
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
     * @param array<string> $allowedValues
     */
    private static function requiredEnumValue(array $requestData, string $field, array $allowedValues): string
    {
        $value = self::nullableEnumValue($requestData, $field, $allowedValues);

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
     */
    private static function nullableBoolean(array $requestData, string $field): ?bool
    {
        if (!array_key_exists($field, $requestData)) {
            return null;
        }

        $rawValue = $requestData[$field];

        if (is_bool($rawValue)) {
            return $rawValue;
        }

        if (!is_scalar($rawValue) && $rawValue !== null) {
            throw new InvalidArgumentException(sprintf('Field "%s" has an invalid type.', $field));
        }

        $value = strtolower(trim((string) $rawValue));

        if ($value === '') {
            return null;
        }

        return match ($value) {
            'yes', 'true', '1' => true,
            'no', 'false', '0' => false,
            default => throw new InvalidArgumentException(sprintf('Field "%s" has an invalid value.', $field)),
        };
    }

    /**
     * @param array<string, mixed> $requestData
     * @param array<string> $fields
     * @param array<string> $multiValueFields
     * @return array<string, mixed>
     */
    private static function collectDetails(array $requestData, array $fields, array $multiValueFields = []): array
    {
        $details = [];

        foreach ($fields as $field) {
            if (in_array($field, $multiValueFields, true)) {
                $value = self::nullableStringArray($requestData, $field);

                if ($value !== null) {
                    $details[$field] = $value;
                }

                continue;
            }

            $value = self::nullableString($requestData, $field);

            if ($value !== null) {
                $details[$field] = $value;
            }
        }

        return $details;
    }

    /**
     * @param array<string, mixed> $requestData
     * @return array<string>|null
     */
    private static function nullableStringArray(array $requestData, string $field): ?array
    {
        if (!array_key_exists($field, $requestData)) {
            return null;
        }

        $rawValue = $requestData[$field];

        if (!is_array($rawValue)) {
            if (!is_scalar($rawValue) && $rawValue !== null) {
                throw new InvalidArgumentException(sprintf('Field "%s" has an invalid type.', $field));
            }

            $singleValue = trim((string) $rawValue);

            return $singleValue === '' ? null : [$singleValue];
        }

        $result = [];

        foreach ($rawValue as $item) {
            if (!is_scalar($item) && $item !== null) {
                throw new InvalidArgumentException(sprintf('Field "%s" has an invalid type.', $field));
            }

            $value = trim((string) $item);

            if ($value !== '') {
                $result[] = $value;
            }
        }

        return $result === [] ? null : $result;
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

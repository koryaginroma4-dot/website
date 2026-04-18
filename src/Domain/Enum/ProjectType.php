<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use App\Domain\Trait\EnumValuesAwareTrait;

enum ProjectType: string
{
    use EnumValuesAwareTrait;

    case GeneralRenovation = 'General Renovation';
    case BasementRenovation = 'Basement Renovation';
    case BathroomRenovation = 'Bathroom Renovation';
    case KitchenRenovation = 'Kitchen Renovation';
    case Flooring = 'Flooring';
    case Painting = 'Painting';
    case Drywall = 'Drywall';
    case Framing = 'Framing';
    case MediaWall = 'Media Wall';
    case HandymanServices = 'Handyman Services';
    case Other = 'Other';
}

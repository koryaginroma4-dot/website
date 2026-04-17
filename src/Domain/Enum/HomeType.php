<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use App\Domain\Trait\EnumValuesAwareTrait;

enum HomeType: string
{
    use EnumValuesAwareTrait;
    
    case Detached = 'Detached';

    case TownHouse = 'TownHouse with garage/driveway';

    case CondoTownHose = 'Condo Townhouse (no driveway)';

    case Condo = 'Condo';
}

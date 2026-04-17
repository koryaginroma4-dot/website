<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use App\Domain\Trait\EnumValuesAwareTrait;

enum FireplaceUnitType: string
{
    use EnumValuesAwareTrait;
    case NeedNewElectricKeeping = 'Need new electric fireplace - keeping';

    case ExistingElectricKeeping = 'Existing Electric fireplace - keeping';

    case NeedNewGas = 'Need new gas fireplace';

    case ExistingGasKeeping = 'Existing gas fireplace - keeping';

    case ExistingGasChange = 'Existing gas fireplace - change to electric';

    case Other = 'Other';
}

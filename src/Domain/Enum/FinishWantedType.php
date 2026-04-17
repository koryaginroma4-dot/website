<?php

declare(strict_types=1);

namespace App\Domain\Enum;

use App\Domain\Trait\EnumValuesAwareTrait;

enum FinishWantedType: string
{
    use EnumValuesAwareTrait;

    case LimeplasterMicrocementVenetianPlaster = 'Limeplaster / Microcement / Venetian plaster';

    case LimewashPaintFinish = 'Limewash Paint finish';

    case WoodSlates = 'Wood slates';

    case RibbedPanels = 'Ribbed panels';

    case LargeMDFPanels = 'Large MDF Panels';

    case Shiplap = 'Shiplap';

    case ConcretePanel = 'Concrete Panel';

    case Tile = 'Tile';

    case Stone = 'Stone';

    case NotSure = 'Not sure';
}

<?php

declare(strict_types=1);

namespace App\Web\Controller\View;
use App\Domain\Enum\FinishWantedType;
use App\Domain\Enum\FireplaceUnitType;
use App\Domain\Enum\HomeType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/application', name: 'application', methods: ['GET'])]
class ApplicationController extends AbstractController
{
    public function __invoke()
    {
        return $this->render('Application/index.html.twig', [
            'page_slug' => 'application',
            'homeTypes' => HomeType::values(),
            'fireplaceUnitTypes' => FireplaceUnitType::values(),
            'finishWantedTypes' => FinishWantedType::values(),
        ]);
    }
}

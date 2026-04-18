<?php

declare(strict_types=1);

namespace App\Web\Controller\View;

use App\Domain\Enum\ProjectType;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/application', name: 'application', methods: ['GET'])]
class ApplicationController extends AbstractController
{
    public function __invoke()
    {
        return $this->render('Application/index.html.twig', [
            'page_slug' => 'application',
            'projectTypes' => ProjectType::values(),
        ]);
    }
}

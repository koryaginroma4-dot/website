<?php

declare(strict_types=1);

namespace App\Web\Controller\View;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '', name: 'home')]
final class HomeController extends AbstractController
{
    public function __invoke()
    {
        return $this->redirectToRoute('slugged_page', ['slug' => 'home']);
    }
}

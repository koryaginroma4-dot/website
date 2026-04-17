<?php

declare(strict_types=1);

namespace App\Web\Controller\View;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(path: '/review', name: 'review', methods: ['GET'])]
final class ReviewController extends AbstractController
{
    public function __invoke()
    {
        return $this->render('Review/index.html.twig', [
            'page_slug' => 'review',
        ]);
    }
}

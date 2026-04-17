<?php

declare(strict_types=1);

namespace App\Web\Controller\View;

use App\Application\Service\CategoryService;
use App\Application\Service\ReviewService;
use App\Web\Trait\TemplateNameFormatterAwareTrait;
use App\Web\Validator\TemplateValidator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Attribute\Route;

#[Route(
    path: '/{slug}',
    name: 'slugged_page',
    requirements: ['slug' => '(?!admin|application|review|api|_)[a-zA-Z0-9][a-zA-Z0-9-]*'],
)]
final class PageController extends AbstractController
{
    use TemplateNameFormatterAwareTrait;

    public function __construct(
        private readonly CategoryService $categoryService,
        private readonly ReviewService $reviewService,
        private readonly TemplateValidator $templateValidator,
    ) {
    }

    public function __invoke(string $slug)
    {
        $template = $this->formatTemplateName($slug);

        $this->templateValidator->validate($template);

        return $this->render($template, [
            'page_slug' => $slug,
            'categories' => $this->categoryService->getAllPositioned(),
            'reviews' => $this->reviewService->getLatest(),
        ]);
    }
}

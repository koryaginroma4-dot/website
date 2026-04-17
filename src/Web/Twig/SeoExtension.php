<?php

declare(strict_types=1);

namespace App\Web\Twig;

use App\Application\Service\SeoService;
use App\Domain\Entity\Seo;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class SeoExtension extends AbstractExtension
{
    public function __construct(
        private readonly SeoService $seoService,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction('seo', [$this, 'seo']),
        ];
    }

    public function seo(?string $pageName): ?Seo
    {
        if ($pageName === null || $pageName === '') {
            return null;
        }

        return $this->seoService->getByPage($pageName);
    }
}

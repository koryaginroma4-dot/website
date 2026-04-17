<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Domain\Entity\Seo;
use App\Infrastructure\Repository\SeoRepository;

class SeoService
{
    public function __construct(
       private readonly SeoRepository $seoRepository, 
    ) {
    }

    public function getByPage(string $slug): ?Seo
    {
        return $this->seoRepository->findOneBy(['pageName' => $slug]);
    }
}

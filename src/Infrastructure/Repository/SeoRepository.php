<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Seo;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

class SeoRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Seo::class);
    }
}

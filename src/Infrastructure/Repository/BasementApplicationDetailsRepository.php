<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\BasementApplicationDetails;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<BasementApplicationDetails>
 */
class BasementApplicationDetailsRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BasementApplicationDetails::class);
    }
}

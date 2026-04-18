<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\BathroomApplicationDetails;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<BathroomApplicationDetails>
 */
class BathroomApplicationDetailsRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, BathroomApplicationDetails::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\KitchenApplicationDetails;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<KitchenApplicationDetails>
 */
class KitchenApplicationDetailsRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, KitchenApplicationDetails::class);
    }
}

<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Application;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Application>
 */
class ApplicationRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Application::class);
    }
}

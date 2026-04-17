<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Category;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Category>
 */
class CategoryRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry) 
    {
        parent::__construct($registry, Category::class);
    }
}

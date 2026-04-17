<?php

declare(strict_types=1);

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Review;
use App\Infrastructure\Abstraction\BaseRepository;
use Doctrine\Persistence\ManagerRegistry;

/**
 * @extends BaseRepository<Review>
 */
class ReviewRepository extends BaseRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Review::class);
    }

    /**
     * @return array<Review>
     */
    public function findLatest(int $limit = 20): array
    {
        /** @var array<Review> $reviews */
        $reviews = $this->createQueryBuilder('review')
            ->orderBy('review.createdAt', 'DESC')
            ->setMaxResults($limit)
            ->getQuery()
            ->getResult();

        return $reviews;
    }
}

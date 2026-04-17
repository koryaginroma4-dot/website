<?php

declare(strict_types=1);

namespace App\Infrastructure\Abstraction;

use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @template T
 * 
 * @extends ServiceEntityRepository<T>
 */
abstract class BaseRepository extends ServiceEntityRepository
{
    /**
     * @param T $entity
     * 
     * This method closed the transaction! Use it carefully
     */
    final public function save(object $entity): void
    {
        $em = $this->getEntityManager();

        $em->persist($entity);
        $em->flush();
    }
}

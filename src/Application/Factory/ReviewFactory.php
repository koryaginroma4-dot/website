<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Application\DTO\ReviewDTO;
use App\Domain\Entity\Review;

class ReviewFactory
{
    public function createFromDTO(ReviewDTO $reviewDTO): Review
    {
        return (new Review())
            ->setAuthorName($reviewDTO->authorName)
            ->setAuthorLocation($reviewDTO->authorLocation)
            ->setComment($reviewDTO->comment)
            ->setResultPhotoUrl($reviewDTO->resultPhotoUrl)
            ->setCreatedAt(new \DateTimeImmutable());
    }
}

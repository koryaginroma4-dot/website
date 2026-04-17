<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\DTO\ReviewDTO;
use App\Application\Exception\SaveReviewException;
use App\Application\Factory\ReviewFactory;
use App\Domain\Entity\Review;
use App\Domain\Exception\Code\Code;
use App\Infrastructure\Repository\ReviewRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class ReviewService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ReviewRepository $reviewRepository,
        private readonly ReviewFactory $reviewFactory,
    ) {
    }

    public function save(ReviewDTO $reviewDTO): void
    {
        try {
            $review = $this->reviewFactory->createFromDTO($reviewDTO);
            $this->reviewRepository->save($review);
        } catch (Throwable $exception) {
            $this->logger->error('saving review error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SaveReviewException(
                'saving review error',
                Code::FATAL,
                $exception
            );
        }
    }

    /**
     * @return array<Review>
     */
    public function getLatest(int $limit = 20): array
    {
        return $this->reviewRepository->findLatest($limit);
    }
}

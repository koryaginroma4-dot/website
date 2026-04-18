<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\SaveApplicationException;
use App\Domain\Entity\Application;
use App\Domain\Entity\KitchenApplicationDetails;
use App\Domain\Exception\Code\Code;
use App\Infrastructure\Repository\KitchenApplicationDetailsRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class KitchenApplicationDetailsService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly KitchenApplicationDetailsRepository $kitchenApplicationDetailsRepository,
    ) {
    }

    /**
     * @param array<string, mixed> $details
     */
    public function save(Application $application, array $details): void
    {
        if ($details === []) {
            return;
        }

        try {
            $entity = (new KitchenApplicationDetails())
                ->setApplication($application)
                ->setDetails($details);

            $this->kitchenApplicationDetailsRepository->save($entity);
        } catch (Throwable $exception) {
            $this->logger->error('saving kitchen application details error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SaveApplicationException(
                'saving kitchen application details error',
                Code::FATAL,
                $exception
            );
        }
    }
}

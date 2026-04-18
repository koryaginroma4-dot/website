<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\SaveApplicationException;
use App\Domain\Entity\Application;
use App\Domain\Entity\BasementApplicationDetails;
use App\Domain\Exception\Code\Code;
use App\Infrastructure\Repository\BasementApplicationDetailsRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class BasementApplicationDetailsService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly BasementApplicationDetailsRepository $basementApplicationDetailsRepository,
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
            $entity = (new BasementApplicationDetails())
                ->setApplication($application)
                ->setDetails($details);

            $this->basementApplicationDetailsRepository->save($entity);
        } catch (Throwable $exception) {
            $this->logger->error('saving basement application details error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SaveApplicationException(
                'saving basement application details error',
                Code::FATAL,
                $exception
            );
        }
    }
}

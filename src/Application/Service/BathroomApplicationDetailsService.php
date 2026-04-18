<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\SaveApplicationException;
use App\Domain\Entity\Application;
use App\Domain\Entity\BathroomApplicationDetails;
use App\Domain\Exception\Code\Code;
use App\Infrastructure\Repository\BathroomApplicationDetailsRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class BathroomApplicationDetailsService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly BathroomApplicationDetailsRepository $bathroomApplicationDetailsRepository,
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
            $entity = (new BathroomApplicationDetails())
                ->setApplication($application)
                ->setDetails($details);

            $this->bathroomApplicationDetailsRepository->save($entity);
        } catch (Throwable $exception) {
            $this->logger->error('saving bathroom application details error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SaveApplicationException(
                'saving bathroom application details error',
                Code::FATAL,
                $exception
            );
        }
    }
}

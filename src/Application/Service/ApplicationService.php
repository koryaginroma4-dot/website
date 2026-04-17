<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\DTO\ApplicationDTO;
use App\Application\Exception\SaveApplicationException;
use App\Application\Factory\ApplicationFactory;
use App\Domain\Exception\Code\Code;
use App\Infrastructure\Repository\ApplicationRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Throwable;

class ApplicationService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ApplicationRepository $applicationRepository,
        private readonly ApplicationFactory $applicationFactory,
        private readonly TelegramService $telegramService,
    ) {
    }

    public function save(ApplicationDTO $applicationDTO): void
    {
        try {
            $application = $this->applicationFactory->createFromDTO($applicationDTO);

            $this->applicationRepository->save($application);

            // $this->telegramService->sendApplicationMessage($application);
        } catch (Throwable $exception) {
            $this->logger->error('saving application error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SaveApplicationException(
                'saving application error',
                Code::FATAL,
                $exception
            );
        }
    }
}

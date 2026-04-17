<?php

declare(strict_types=1);

namespace App\Application\Service;

use App\Application\Exception\SendingTelegramNotificationException;
use App\Application\Factory\TelegramMessageFactory;
use App\Domain\Entity\Application;
use App\Domain\Exception\Code\Code;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\Notifier\ChatterInterface;
use Throwable;

class TelegramService implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __construct(
        private readonly ChatterInterface $chatter,
        private readonly TelegramMessageFactory $telegramMessageFactory,
    ) {
    }

    public function sendApplicationMessage(Application $application): void
    {
        try {
            $message = $this->telegramMessageFactory->createFromApplication($application);
            
            $this->chatter->send($message);
        } catch (Throwable $exception) {
            $this->logger->error('sending telegram notification error', [
                'message' => $exception->getMessage(),
                'trace' => $exception->getTraceAsString(),
            ]);

            throw new SendingTelegramNotificationException(
                'sending telegram notification error',
                Code::FATAL,
                $exception
            );
        }
    }
}

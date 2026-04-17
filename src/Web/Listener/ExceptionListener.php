<?php

declare(strict_types=1);

namespace App\Web\Listener;

use App\Web\Exception\ValidationException;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener implements LoggerAwareInterface
{
    use LoggerAwareTrait;

    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        if ($exception instanceof ValidationException) {
            $this->logger->info($exception->getMessage());

            $response = new Response();
            $response->setContent("Not found!");
            $response->setStatusCode(Response::HTTP_NOT_FOUND);
            $response->headers->set('Content-Type', 'text/plain; charset=utf-8');

            $event->setResponse($response);
        }
    }
}

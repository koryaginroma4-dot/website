<?php

declare(strict_types=1);

namespace App\Application\Data;

use Symfony\Component\DependencyInjection\Attribute\Autowire;

final class TelegramData
{
    public function __construct(
        #[Autowire(param: 'telegram_chat_id')]
        public readonly string $chatId
    ) {
    }
}

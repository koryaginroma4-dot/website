<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Application\Data\TelegramData;
use App\Domain\Entity\Application;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\Notifier\Bridge\Telegram\TelegramOptions;
use Symfony\Component\Notifier\Message\ChatMessage;

class TelegramMessageFactory
{
    public function __construct(
        private readonly TelegramData $telegramData,
        #[Autowire(param: 'kernel.project_dir')]
        private readonly string $projectDir,
    ) {
    }

    public function createFromApplication(Application $application): ChatMessage
    {
        $options = new TelegramOptions()
            ->chatId($this->telegramData->chatId);

        if ($application->getSpacePhoto() !== null) {
            $absolutePhotoPath = sprintf(
                '%s/public/%s',
                $this->projectDir,
                ltrim($application->getSpacePhoto(), '/')
            );

            if (is_readable($absolutePhotoPath)) {
                $options->photo($absolutePhotoPath);
            }
        }
        $message = implode(PHP_EOL, [
            'New application received',
            sprintf('Name: %s', $application->getName()),
            sprintf('Email: %s', $application->getEmail()),
            sprintf('Phone: %s', $application->getPhone()),
            sprintf('City: %s', $application->getCity()),
            sprintf('Home type: %s', $application->getHomeType() ?? '-'),
            sprintf('Fireplace unit: %s', $application->getFireplaceUnit() ?? '-'),
            sprintf('Finish wanted: %s', $application->getFinishWanted() ?? '-'),
            sprintf('Space setup: %s', $application->getSpaceSetup() ?? '-'),
            sprintf('How did you hear about us: %s', $application->getHowDidYourHearAboutUs() ?? '-'),
            sprintf('Additional notes: %s', $application->getAdditionalNotes()),
        ]);


        return new ChatMessage($message, $options);
    }
}

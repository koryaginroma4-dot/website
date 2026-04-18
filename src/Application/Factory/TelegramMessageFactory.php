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
        $firstPhotoPath = $this->extractFirstPhotoPath($application->getSpacePhoto());

        if ($firstPhotoPath !== null) {
            $absolutePhotoPath = sprintf(
                '%s/public/%s',
                $this->projectDir,
                ltrim($firstPhotoPath, '/')
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
            sprintf('Project type: %s', $application->getProjectType()),
            sprintf('Preferred start: %s', $application->getPreferredStartTime() ?? '-'),
            sprintf('Budget range: %s', $application->getBudgetRange() ?? '-'),
            sprintf(
                'Owns property: %s',
                $application->getOwnsProperty() === null
                    ? '-'
                    : ($application->getOwnsProperty() ? 'Yes' : 'No')
            ),
            sprintf('Home type: %s', $application->getHomeType() ?? '-'),
            sprintf('Fireplace unit: %s', $application->getFireplaceUnit() ?? '-'),
            sprintf('Finish wanted: %s', $application->getFinishWanted() ?? '-'),
            sprintf('Space setup: %s', $application->getSpaceSetup() ?? '-'),
            sprintf('How did you hear about us: %s', $application->getHowDidYourHearAboutUs() ?? '-'),
            sprintf('Uploaded photos: %s', $this->formatPhotoPaths($application->getSpacePhoto())),
            sprintf('Additional notes: %s', $application->getAdditionalNotes()),
        ]);


        return new ChatMessage($message, $options);
    }

    private function extractFirstPhotoPath(?string $spacePhoto): ?string
    {
        $photoPaths = $this->extractPhotoPaths($spacePhoto);

        return $photoPaths[0] ?? null;
    }

    /**
     * @return array<string>
     */
    private function extractPhotoPaths(?string $spacePhoto): array
    {
        if ($spacePhoto === null || trim($spacePhoto) === '') {
            return [];
        }

        $parts = preg_split('/\R+/', $spacePhoto);

        if (!is_array($parts)) {
            return [];
        }

        return array_values(array_filter(array_map('trim', $parts), static fn (string $path): bool => $path !== ''));
    }

    private function formatPhotoPaths(?string $spacePhoto): string
    {
        $photoPaths = $this->extractPhotoPaths($spacePhoto);

        return $photoPaths === [] ? '-' : implode(', ', $photoPaths);
    }
}

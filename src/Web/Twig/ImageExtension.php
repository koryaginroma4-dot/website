<?php

declare(strict_types=1);

namespace App\Web\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ImageExtension extends AbstractExtension
{
    public const string IMAGE_BASE_PATH_FORMAT = '/upload/images/%s';

    public function getFunctions(): array
    {
        return [
            new TwigFunction('image_url', [$this, 'imageUrl']),
        ];
    }

    public function imageUrl(string $imageUrl)
    {
        return sprintf(self::IMAGE_BASE_PATH_FORMAT, $imageUrl);
    }
}

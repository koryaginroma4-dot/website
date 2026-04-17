<?php

declare(strict_types=1);

namespace App\Web\Validator;

use App\Web\Exception\UnexistedTemplateException;
use Twig\Environment;

class TemplateValidator
{
    public function __construct(
        private Environment $twig
    ) {
    }

    /**
     * @throws UnexistedTemplateException
     */
    public function validate(string $template)
    {
        if (!$this->twig->getLoader()->exists($template)) {
            throw new UnexistedTemplateException($template);
        }
    }
}

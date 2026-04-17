<?php

declare(strict_types=1);

namespace App\Web\Exception;

use Symfony\Component\HttpFoundation\Response;

class UnexistedTemplateException extends ValidationException
{
    public function __construct(string $template) {
        parent::__construct("template {$template} doesn't exists", Response::HTTP_NOT_FOUND);
    }
}

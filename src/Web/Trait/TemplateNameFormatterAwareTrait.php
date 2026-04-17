<?php

declare(strict_types=1);

namespace App\Web\Trait;

trait TemplateNameFormatterAwareTrait
{
    protected const string TEMPLATE_NAME_FORMAT = "%s/index.html.twig";

    protected function formatTemplateName(string $pageSlug): string
    {
        $capitalizedSlug = ucfirst($pageSlug);

        return sprintf(self::TEMPLATE_NAME_FORMAT, $capitalizedSlug);
    }
}

<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Stringable;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Embeddable]
final class Phone implements Stringable
{
    #[ORM\Column(name: 'phone', type: 'string', length: 20, nullable: false)]
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: 'Phone number must be at least {{ limit }} characters',
        maxMessage: 'Phone number cannot be longer than {{ limit }} characters'
    )]
    #[Assert\Regex(
        pattern: '/^\+?[0-9\s\-\(\)]+$/',
        message: 'Phone number contains invalid characters'
    )]
    private string $value;

    public function __construct(string $value)
    {
        $this->value = $value;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function __toString(): string
    {
        return $this->value;
    }
}
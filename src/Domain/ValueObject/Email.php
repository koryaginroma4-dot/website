<?php

declare(strict_types=1);

namespace App\Domain\ValueObject;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;
use InvalidArgumentException;
use Stringable;

#[ORM\Embeddable]
class Email implements Stringable
{
    #[ORM\Column(name: 'email', type: Types::STRING, length: 180, unique: false, nullable: false)]
    private string $value;


    public function __construct(string $value)
    {
        $this->validate($value);
        $this->value = $value;
    }

    private function validate(string $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
            throw new InvalidArgumentException(sprintf('Invalid email address: "%s"', $value));
        }
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

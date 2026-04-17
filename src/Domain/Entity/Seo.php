<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Repository\SeoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeoRepository::class)]
#[ORM\Table(name: 'seo')]
class Seo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $title;

    #[ORM\Column(length: 160)]
    private string $metaDesription;

    #[ORM\Column(length: 255)]
    private string $pageName;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getMetaDesription(): string
    {
        return $this->metaDesription;
    }

    public function setMetaDesription(string $metaDesription): self
    {
        $this->metaDesription = $metaDesription;

        return $this;
    }

    public function getPageName(): string
    {
        return $this->pageName;
    }

    public function setPageName(string $pageName): self
    {
        $this->pageName = $pageName;

        return $this;
    }
}

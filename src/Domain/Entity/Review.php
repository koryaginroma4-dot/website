<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Infrastructure\Repository\ReviewRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ReviewRepository::class)]
#[ORM\Table(name: 'reviews')]
class Review
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $authorName;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $authorLocation = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $comment;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $photoUrl = null;
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $resultPhotoUrl = null;

    #[ORM\Column(type: Types::DATETIME_IMMUTABLE)]
    private \DateTimeImmutable $createdAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAuthorName(): string
    {
        return $this->authorName;
    }

    public function setAuthorName(string $authorName): self
    {
        $this->authorName = $authorName;

        return $this;
    }

    public function getAuthorLocation(): ?string
    {
        return $this->authorLocation;
    }

    public function setAuthorLocation(?string $authorLocation): self
    {
        $this->authorLocation = $authorLocation;

        return $this;
    }

    public function getComment(): string
    {
        return $this->comment;
    }

    public function setComment(string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getCreatedAt(): \DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getPhotoUrl(): ?string
    {
        return $this->photoUrl;
    }
    
    public function setPhotoUrl(?string $photoUrl = null): self
    {
        $this->photoUrl = $photoUrl;

        return $this;
    }

    public function getResultPhotoUrl(): ?string
    {
        return $this->resultPhotoUrl;
    }

    public function setResultPhotoUrl(?string $resultPhotoUrl = null): self
    {
        $this->resultPhotoUrl = $resultPhotoUrl;

        return $this;
    }
}

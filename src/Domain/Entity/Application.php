<?php

declare(strict_types=1);

namespace App\Domain\Entity;

use App\Domain\ValueObject\Email;
use App\Domain\ValueObject\Phone;
use App\Infrastructure\Repository\ApplicationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ApplicationRepository::class)]
#[ORM\Table(name: 'applications')]
class Application
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Embedded(class: Email::class, columnPrefix: false)]
    private Email $email;

    #[ORM\Embedded(class: Phone::class, columnPrefix: false)]
    private Phone $phone;

    #[ORM\Column(length: 255)]
    private string $city;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $howDidYourHearAboutUs = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $homeType = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $spaceSetup = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $fireplaceUnit = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $finishWanted = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $spacePhoto = null;

    #[ORM\Column(type: Types::TEXT)]
    private string $additionalNotes;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email->getValue();
    }

    public function setEmail(string $email): self
    {
        $this->email = new Email($email);

        return $this;
    }

    public function getPhone(): string
    {
        return $this->phone->getValue();
    }

    public function setPhone(string $phone): self
    {
        $this->phone = new Phone($phone);

        return $this;
    }

    public function getCity(): string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getHowDidYourHearAboutUs(): ?string
    {
        return $this->howDidYourHearAboutUs;
    }

    public function setHowDidYourHearAboutUs(?string $howDidYourHearAboutUs): self
    {
        $this->howDidYourHearAboutUs = $howDidYourHearAboutUs;

        return $this;
    }

    public function getHomeType(): ?string
    {
        return $this->homeType;
    }

    public function setHomeType(?string $homeType): self
    {
        $this->homeType = $homeType;

        return $this;
    }

    public function getSpaceSetup(): ?string
    {
        return $this->spaceSetup;
    }

    public function setSpaceSetup(?string $spaceSetup): self
    {
        $this->spaceSetup = $spaceSetup;

        return $this;
    }

    public function getFireplaceUnit(): ?string
    {
        return $this->fireplaceUnit;
    }

    public function setFireplaceUnit(?string $fireplaceUnit): self
    {
        $this->fireplaceUnit = $fireplaceUnit;

        return $this;
    }

    public function getFinishWanted(): ?string
    {
        return $this->finishWanted;
    }

    public function setFinishWanted(?string $finishWanted): self
    {
        $this->finishWanted = $finishWanted;

        return $this;
    }

    public function getSpacePhoto(): ?string
    {
        return $this->spacePhoto;
    }

    public function setSpacePhoto(?string $spacePhoto): self
    {
        $this->spacePhoto = $spacePhoto;

        return $this;
    }

    public function getAdditionalNotes(): string
    {
        return $this->additionalNotes;
    }

    public function setAdditionalNotes(string $additionalNotes): self
    {
        $this->additionalNotes = $additionalNotes;

        return $this;
    }
}

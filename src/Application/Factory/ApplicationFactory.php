<?php

declare(strict_types=1);

namespace App\Application\Factory;

use App\Application\DTO\ApplicationDTO;
use App\Domain\Entity\Application;

class ApplicationFactory
{
    public function createFromDTO(ApplicationDTO $applicationDTO): Application
    {
        return (new Application())
            ->setName($applicationDTO->name)
            ->setEmail($applicationDTO->email)
            ->setPhone($applicationDTO->phone)
            ->setCity($applicationDTO->city)
            ->setHowDidYourHearAboutUs($applicationDTO->howDidYourHearAboutUs)
            ->setHomeType($applicationDTO->homeType)
            ->setSpaceSetup($applicationDTO->spaceSetup)
            ->setFireplaceUnit($applicationDTO->fireplaceUnit)
            ->setFinishWanted($applicationDTO->finishWanted)
            ->setSpacePhoto($applicationDTO->spacePhoto)
            ->setAdditionalNotes($applicationDTO->additionalNotes);
    }
}

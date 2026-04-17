<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use App\Domain\Entity\Application;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ApplicationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Application::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Application')
            ->setEntityLabelInPlural('Applications')
            ->setDefaultSort(['id' => 'DESC']);
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->disable(Action::NEW);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('name');
        yield EmailField::new('email');
        yield TelephoneField::new('phone');
        yield TextField::new('city');
        yield TextField::new('homeType')->hideOnIndex();
        yield TextField::new('fireplaceUnit')->hideOnIndex();
        yield TextField::new('finishWanted')->hideOnIndex();
        yield TextareaField::new('howDidYourHearAboutUs')->hideOnIndex();
        yield TextareaField::new('spaceSetup')->hideOnIndex();
        yield TextareaField::new('spacePhoto')->hideOnIndex();
        yield TextareaField::new('additionalNotes')->hideOnIndex();
    }
}

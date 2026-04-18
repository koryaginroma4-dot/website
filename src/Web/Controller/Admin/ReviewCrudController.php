<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use App\Domain\Entity\Review;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;

class ReviewCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Review::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Review')
            ->setEntityLabelInPlural('Reviews')
            ->setDefaultSort(['createdAt' => 'DESC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('authorName');
        yield TextField::new('authorLocation');
        yield TextareaField::new('comment');

        yield ImageField::new('photoUrl', 'Author photo')
            ->setBasePath('upload/images')
            ->setUploadDir('public/upload/images')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setFormTypeOptions([
                'required' => false,
            ]);

        yield ImageField::new('resultPhotoUrl', 'Result photo')
            ->setBasePath('upload/images')
            ->setUploadDir('public/upload/images')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setFormTypeOptions([
                'required' => false,
            ]);
    }
}

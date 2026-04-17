<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use App\Domain\Entity\Category;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CategoryCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Category::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('Category')
            ->setEntityLabelInPlural('Categories');
    }

    public function configureFields(string $pageName): iterable
    {       
        yield TextField::new('name');
            
        yield TextEditorField::new('description');
            
        yield IntegerField::new('position');
            
        yield BooleanField::new('showOnSite');

        yield ImageField::new('ImageUrl')
            ->setBasePath('upload/images')
            ->setUploadDir('public/upload/images')
            ->setUploadedFileNamePattern('[slug]-[timestamp].[extension]')
            ->setFormTypeOptions([
                'required' => true,
            ]);
    }
}

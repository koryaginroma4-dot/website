<?php

declare(strict_types=1);

namespace App\Web\Controller\Admin;

use App\Domain\Entity\Seo;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeoCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seo::class;
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->setEntityLabelInSingular('SEO')
            ->setEntityLabelInPlural('SEO')
            ->setSearchFields(['pageName', 'title'])
            ->setDefaultSort(['pageName' => 'ASC']);
    }

    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')->hideOnForm();
        yield TextField::new('pageName', 'Page slug')
            ->setHelp('Slug used in the URL, e.g. "home", "about", "application", "review".');
        yield TextField::new('title');
        yield TextareaField::new('metaDesription', 'Meta description')
            ->setMaxLength(160);
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\ProductManufacturer;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductManufacturerCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductManufacturer::class;
    }
    public function configureActions(Actions $actions): Actions{
        return $actions->disable(Crud::PAGE_NEW, Action::NEW, Action::DELETE, Action::BATCH_DELETE);
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud->showEntityActionsInlined();
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('code'),
            TextField::new('name'),
        ];
    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Product;
use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CurrencyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class ProductCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Product::class;
    }

    public function configureActions(Actions $actions): Actions{
        return $actions->disable(Crud::PAGE_NEW, Action::NEW, Action::DELETE, Action::BATCH_DELETE);
    }

    public function configureCrud(Crud $crud): Crud {
        return $crud->showEntityActionsInlined();
    }


    public function configureFields(string $pageName): iterable
    {

        if ($pageName == Crud::PAGE_INDEX) {
            return [
                TextField::new('itemNumber'),
                TextField::new('name'),
                MoneyField::new('price')->setCurrency('USD')->setStoredAsCents(),
                TextField::new('type'),
                TextField::new('manufacturer'),
                IntegerField::new('stockQuantity'),
                DateField::new('erpCreateDate'),
                BooleanField::new('active')->renderAsSwitch(false),
            ];
        } else {
            return [
                FormField::addTab('Product Details'),
                TextareaField::new('description'),
                TextareaField::new('keywords'),
                BooleanField::new('active'),
                BooleanField::new('video'),
                TextField::new('brand'),
                MoneyField::new('mapPrice')->setCurrency('USD')->setStoredAsCents(),
                BooleanField::new('amazonRestricted'),
                BooleanField::new('approvalRequired'),

                FormField::addTab('Package Dimensions'),
                NumberField::new('height'),
                NumberField::new('length'),
                NumberField::new('width'),
                NumberField::new('diameter'),
                NumberField::new('weight'),

                FormField::addTab('Product Attributes'),
                TextField::new('color'),
                TextField::new('material'),
                NumberField::new('productLength'),
                NumberField::new('insertableLength'),
                BooleanField::new('realistic'),
                BooleanField::new('balls'),
                BooleanField::new('suctionCup'),
                BooleanField::new('harness'),
                BooleanField::new('vibrating'),
                BooleanField::new('thick'),
                BooleanField::new('doubleEnded'),
                NumberField::new('circumference'),
                
                FormField::addTab('Product Images'),
                CollectionField::new('images')->useEntryCrudForm()->renderExpanded()->setEntryIsComplex()
            ];
        }
    }
    
}

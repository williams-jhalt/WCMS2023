<?php

namespace App\Controller\Admin;

use App\Entity\ProductImage;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return ProductImage::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($pageName == Crud::PAGE_EDIT || $pageName == Crud::PAGE_NEW) {
            return [
                TextareaField::new('imageFile')
                    ->setFormType(VichImageType::class)
                    ->setFormTypeOptions(['allow_delete' => false]),
                BooleanField::new('explicit'),
                BooleanField::new('primaryImage')
            ];
        } else {
            return [
                TextField::new('image.name', "Filename"),
                TextField::new('product.itemNumber', "Item Number")
            ];
        }
    }

}
<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }

    public function configureFields(string $pageName): iterable
    {

        if ($pageName == Crud::PAGE_INDEX) {
            return [
                TextField::new('email'),
                AssociationField::new('customers')
            ];
        } 
        
        if ($pageName == Crud::PAGE_EDIT) {
            return [
                TextField::new('email'),
                // TextField::new('password')->setFormType(PasswordType::class),
            ];
        }

        return [
            TextField::new('email'),
            TextField::new('password')->setFormType(PasswordType::class)
        ];

    }
}
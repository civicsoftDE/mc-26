<?php

namespace App\Controller\Admin;

use App\Entity\EventLocation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class EventLocationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventLocation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description'),
            TextField::new('street'),
            TextField::new('zipCode'),
            TextField::new('city'),
            TextField::new('country'),
            TextField::new('websiteUrl'),
            TextField::new('phone'),
            TextField::new('email'),
            BooleanField::new('isActive'),
        ];
    }

}

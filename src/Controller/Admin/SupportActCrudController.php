<?php

namespace App\Controller\Admin;

use App\Entity\SupportAct;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SupportActCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SupportAct::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name'),
            TextEditorField::new('description')->onlyOnForms(),
            TextField::new('websiteUrl'),
            TextField::new('instagram')->onlyOnForms(),
            TextField::new('youtube')->onlyOnForms(),
            TextField::new('bandcamp')->onlyOnForms(),
            TextField::new('spotify')->onlyOnForms(),
            TextField::new('email'),
            TextField::new('phone'),
        ];
    }

}

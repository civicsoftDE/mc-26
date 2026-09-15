<?php

namespace App\Controller\Admin;

use App\Entity\BandMember;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BandMemberCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return BandMember::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('nickname'),
            TextField::new('shortDescription'),
            TextEditorField::new('description'),
            ImageField::new('imageName')
                ->setBasePath('/images/members')
                ->setUploadDir('public/images/members')
                ->setFormTypeOptions([
                    'required' => false,
                    'allow_delete' => true,
                ])
                ->setLabel('Bild'),
            BooleanField::new('isHelpingHand'),
            BooleanField::new('isOld'),
            DateField::new('beginDate'),
            DateField::new('endDate'),
        ];
    }

}

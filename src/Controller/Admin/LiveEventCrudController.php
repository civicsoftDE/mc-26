<?php

namespace App\Controller\Admin;

use App\Entity\LiveEvent;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\MoneyField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LiveEventCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return LiveEvent::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Allgemein'),
            TextField::new('title'),
            TextField::new('shortDescription'),
            TextEditorField::new('description'),
            AssociationField::new('location'),
            AssociationField::new('supportActs')->onlyOnForms(),
            ImageField::new('imageName')
                // Muss exakt dem 'uri_prefix' aus der vich_uploader.yaml entsprechen
                ->setBasePath('/images/concerts')
                // Muss exakt dem 'upload_destination' aus der vich_uploader.yaml entsprechen
                ->setUploadDir('public/images/concerts')
                ->setFormTypeOptions([
                    'required' => false, // Macht das Hochladen optional
                    'allow_delete' => true, // Zeigt eine Checkbox zum Löschen des Bildes im Edit-Formular
                ])
                //->onlyOnIndex()
                ->setLabel('Bild'),

            FormField::addTab('Zeit'),
            DateTimeField::new('startsAt'),
            DateTimeField::new('doorsOpenAt')->onlyOnForms(),
            DateTimeField::new('endsAt')->onlyOnForms(),

            FormField::addTab('Tickets'),
            BooleanField::new('hasTickets')->onlyOnForms(),
            IntegerField::new('ticketAmount')->onlyOnForms(),
            BooleanField::new('hasVkk')->onlyOnForms(),
            MoneyField::new('pricePresale')->onlyOnForms()
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
            BooleanField::new('hasAk')->onlyOnForms(),
            MoneyField::new('priceDoor')->onlyOnForms()
                ->setCurrency('EUR')
                ->setStoredAsCents(false),
            BooleanField::new('isFreeEntry')->onlyOnForms(),
            BooleanField::new('isSoldOut'),
            BooleanField::new('isCanceled'),

            FormField::addTab('Jugendschutz'),
            BooleanField::new('isAgeRestricted')->onlyOnForms(),
            IntegerField::new('ageLimit')->onlyOnForms(),
        ];
    }

}

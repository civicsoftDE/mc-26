<?php

namespace App\Controller\Admin;

use App\Entity\EventPicture;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichImageType;

class EventPictureCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return EventPicture::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            FormField::addTab('Allgemein'),
            BooleanField::new('isPublished'),
            AssociationField::new('liveEvent'),
            AssociationField::new('publishedBy'),

            TextField::new('imageFile')
                ->setFormType(VichImageType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'download_uri' => true, // oder 'imageUri' für Vorschau
                    'allow_delete' => true,
                ])
                ->setLabel('Bild')
                ->onlyOnForms(), // Nur in Create/Edit zeigen

            // Für die Index/Detail-Anzeige das gespeicherte Bild zeigen
            ImageField::new('imageName')
                ->setBasePath('/images/concert_images')
                // Muss exakt dem 'upload_destination' aus der vich_uploader.yaml entsprechen
                ->setUploadDir('public/images/concert_images')
                ->setLabel('Bild')
                ->hideOnForm(),

        ];
    }

}

<?php

namespace App\Controller\Admin;

use App\Entity\Music;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Vich\UploaderBundle\Form\Type\VichFileType;

class MusicCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Music::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title'),
            TextEditorField::new('description'),
            BooleanField::new('isPublished'),
            TextField::new('imageFile')
                ->setFormType(VichFileType::class)
                ->setFormTypeOptions([
                    'required' => false,
                    'download_uri' => true, // oder 'imageUri' für Vorschau
                    'allow_delete' => true,
                ])
                ->setLabel('Bild')
                ->onlyOnForms(), // Nur in Create/Edit zeigen

            Field::new('imageName')
                ->setTemplatePath('admin/field/audio_player.html.twig')
                ->setLabel('Bild')
                ->hideOnForm(),
        ];
    }

}

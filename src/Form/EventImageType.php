<?php

namespace App\Form;

use App\Entity\EventPicture;
use App\Entity\LiveEvent;
use App\Entity\User;
use App\Repository\LiveEventRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichFileType;

class EventImageType extends AbstractType
{
    private LiveEventRepository $liveEventRepository;

    // Repository per Autowiring injizieren
    public function __construct(LiveEventRepository $liveEventRepository)
    {
        $this->liveEventRepository = $liveEventRepository;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('liveEvent', EntityType::class, [
                'class' => LiveEvent::class, // TODO: nur LiveEventRepository->getPastConcerts
                'choice_label' =>  fn($event) => $event->getTitle() . ' (' . $event->getStartsAt()->format('d.m.Y') . ')',
                'choices' => $this->liveEventRepository->findPastConcerts(),
                'by_reference' => false,
            ])
            ->add('imageFile', VichFileType::class, [
                'required'      => true,
                'allow_delete'  => false,
                'download_uri'  => false,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => EventPicture::class,
        ]);
    }
}

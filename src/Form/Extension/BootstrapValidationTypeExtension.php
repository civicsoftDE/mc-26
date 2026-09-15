<?php

namespace App\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BootstrapValidationTypeExtension extends AbstractTypeExtension
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'valid_feedback' => null,
            'invalid_feedback' => null,
        ]);

        $resolver->setAllowedTypes('valid_feedback', ['null', 'string']);
        $resolver->setAllowedTypes('invalid_feedback', ['null', 'string']);
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['valid_feedback'] = $options['valid_feedback'];
        $view->vars['invalid_feedback'] = $options['invalid_feedback'];
    }

    public static function getExtendedTypes(): iterable
    {
        return [FormType::class];
    }
}

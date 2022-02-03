<?php

namespace App\Form;

use App\Entity\Lexicon;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class LexiconType extends \Symfony\Component\Form\AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Créer un nouveau lexique',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control w-25']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Lexicon::class,
        ]);
    }
}

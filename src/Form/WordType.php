<?php

namespace App\Form;

use App\Entity\Word;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WordType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'name',
                TextType::class,
                [
                    'label' => 'Entrer un nouveau mot',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'definition',
                TextareaType::class,
                [
                    'label' => 'Définition',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'imageFile',
                FileType::class,
                [
                    'required' => false,
                    'label' => 'Joindre une image',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
        ]);
    }
}

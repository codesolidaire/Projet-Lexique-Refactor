<?php

namespace App\Form;

use App\Model\Contact;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ContactType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add(
                'firstname',
                TextType::class,
                [
                    'label' => 'Prénom',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'lastname',
                TextType::class,
                [
                    'label' => 'nom',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'email',
                TextType::class,
                [
                    'label' => 'Email',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'title',
                TextType::class,
                [
                    'label' => 'Sujet',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'message',
                TextareaType::class,
                [
                    'label' => 'Message',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            );
    }


    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Contact::class
        ]);
    }
}

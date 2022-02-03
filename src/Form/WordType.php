<?php

namespace App\Form;

use App\Entity\Lexicon;
use App\Entity\Word;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;

class WordType extends AbstractType
{
    private Security $security;
    public function __construct(Security $securityContext)
    {
        $this->security = $securityContext;
    }
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
                TextType::class,
                [
                    'label' => 'Définition',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'imageFile',
                TextType::class,
                [
                    'required' => false,
                    'label' => 'Joindre une image',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control']
                ]
            )
            ->add(
                'Lexicon',
                EntityType::class,
                [
                    'class' => Lexicon::class,

                    'choice_label' => 'title',
                    'label_attr' => ['class' => 'form-label'],
                    'attr' => ['class' => 'form-control'],
                    'query_builder' => function (EntityRepository $er) {
                        return $er->createQueryBuilder('u')
                            ->where('u.user = :uid')
                            ->setParameter('uid', $this->security->getToken()->getUser());
                    }]
            );
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
        ]);
    }
}

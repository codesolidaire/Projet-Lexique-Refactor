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

class WordType extends AbstractType
{
    private $security;
    public function __construct(Security $securityContext)
    {
        $this->security = $securityContext;
    }
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name')
            ->add('definition')
            ->add('imageFile', FileType::class, [
                'required' => false
            ])
            ->add('lexicon', EntityType::class, [
                'class' => Lexicon::class,
                'choice_label' => 'title',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                       ->where('u.user = :uid')
                       ->setParameter('uid', $this->security->getToken()->getUser());
                }]);

    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Word::class,
        ]);
    }
}

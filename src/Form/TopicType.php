<?php

namespace App\Form;

use App\Entity\Topic;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('title', TextType::class, [
                'label' => 'Sujet',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>['class'=> 'form-control'],
                'required' => true
            ])
            ->add('category', TextType::class, [
                'label' => 'Catégorie',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>[
                    'class'=> 'form-control',
                    'list' => 'categories'
                ],
                'required' => true,
                'mapped' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer un sujet',
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}

<?php

namespace App\Form;

use App\Entity\User;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\RepeatedType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class RegisterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('lastname', TextType::class, [
                'label' => 'Nom',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>[
                    'class'=> 'form-control'
                ],
                'required' => false,
            ])
            ->add('firstname', TextType::class, [
                'label' => 'Prénom',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>[
                    'class'=> 'form-control'
                ],
                'required' => false,
            ])
            ->add('username', TextType::class, [
                'label' => 'Pseudo *',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>[
                    'class'=> 'form-control'
                ],
                'required' => true,
                'help' => 'Le pseudo doit faire au minimum 6 caractères',
                'help_attr' => ['class'=>'form-text text-muted'],
            ])
            ->add('password', RepeatedType::class, [
                'type' => PasswordType::class,
                'invalid_message' => 'Les mots de passe doivent correspondre.',
                'options' => ['attr' => ['class' => 'form-control']],
                'first_options'  => [
                    'label' => 'Mot de passe *',
                    'help' => 'Le mot de passe doit faire au minimum 6 caractères',
                    'help_attr' => ['class'=>'form-text text-muted'],
                ],
                'second_options' => [
                    'label' => 'Répétez le mot de passe *',
                    'help' => 'Les mots de passe doivent correspondre',
                    'help_attr' => ['class'=>'form-text text-muted'],
                ],
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'required' => true,
            ])
            ->add('address', TextType::class, [
                'label' => 'Adresse',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>['class'=> 'form-control'],
                'required' => false
            ])
            ->add('postalCode', TextType::class, [
                'label' => 'Code postal',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>['class'=> 'form-control'],
                'required' => false
            ])
            ->add('city', TextType::class, [
                'label' => 'Ville',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>['class'=> 'form-control'],
                'required' => false
            ])
            ->add('email', EmailType::class, [
                'label' => 'Email *',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>['class'=> 'form-control'],
                'required' => true
            ])
            ->add('phone', TextType::class, [
                'label' => 'Numéro de téléphone',
                'row_attr' => ['class' => 'mb-3'],
                'label_attr' =>['class'=> 'form-label'],
                'attr' =>[
                    'class'=> 'form-control',
                    'pattern' => "[0-9]{10}"
                ],
                'required' => false
            ])
            ->add('save', SubmitType::class, [
                'label' => 'Créer un compte',
                'attr' => ['class' => 'btn btn-primary']
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => User::class,
        ]);
    }
}

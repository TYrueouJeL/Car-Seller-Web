<?php

namespace App\Form;

use App\Entity\Customer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class RegistrationFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('email', null, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-input', 'autocomplete' => 'email'],
            ])
            ->add('plainPassword', PasswordType::class, [
                'mapped' => false,
                'row_attr' => ['class' => 'form-row'],
                'label' => 'Mot de passe',
                'label_attr' => ['class' => 'form-label'],
                'attr' => ['class' => 'form-input', 'autocomplete' => 'new-password'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de remplir ce champ',
                    ]),
                    new Length([
                        'min' => 6,
                        'minMessage' => 'Votre mot de passe doit au moins avoir 6 caractères de long.',
                        // max length allowed by Symfony for security reasons
                        'max' => 4096,
                    ]),
                ],
            ])
            ->add('firstname', TextType::class, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Prénom',
                'attr' => ['class' => 'form-input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de remplir ce champ',
                    ])
                ]
            ])
            ->add('lastname', TextType::class, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Nom',
                'attr' => ['class' => 'form-input'],
                'constraints' => [
                    new NotBlank([
                        'message' => 'Merci de remplir ce champ',
                    ])
                ]
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Customer::class,
            'attr' => ['class' => 'form'],
        ]);
    }
}

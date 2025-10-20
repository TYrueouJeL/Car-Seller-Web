<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\MaintenanceRequest;
use App\Entity\Technician;
use App\Entity\Type;
use App\Entity\UserVehicle;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class MaintenanceRequestFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('requestDate', DateTimeType::class, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Date de la demande',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('type', EntityType::class, [
                'class' => Type::class,
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Type de maintenance',
                'attr' => ['class' => 'form-input'],
                'choice_label' => 'name',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => MaintenanceRequest::class,
            'attr' => ['class' => 'form'],
        ]);
    }
}

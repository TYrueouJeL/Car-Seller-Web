<?php

namespace App\Form;

use App\Entity\Customer;
use App\Entity\RentableVehicle;
use App\Entity\RentalOrder;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateIntervalType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints\Date;

class RentalOrderFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('startDate', DateType::class, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Date de début',
                'attr' => ['class' => 'form-input'],
            ])
            ->add('endDate', DateType::class, [
                'row_attr' => ['class' => 'form-row'],
                'label_attr' => ['class' => 'form-label'],
                'label' => 'Date de fin',
                'attr' => ['class' => 'form-input'],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RentalOrder::class,
            'attr' => ['class' => 'form'],
        ]);
    }
}

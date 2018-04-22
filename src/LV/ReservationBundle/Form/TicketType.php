<?php

namespace LV\ReservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use \Symfony\Component\Form\Extension\Core\Type\BirthdayType;


class TicketType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('reducedPrice', CheckboxType::class, array(
            'required' => false,
            'label'=>'Tarif réduit (o/n)'
            ))
        ->add('customerName',  TextType::class, ["label"=>"Nom"])
        ->add('customerFirstName',  TextType::class, ["label"=>"Prénom"])
        ->add('customerCountry',  TextType::class, ["label"=>"Pays"])
        ->add('customerBirthDate', BirthdayType::class, array(
            'label' => 'Date de naissance',
            'years' => range(date('Y'), 1930),
            'format' => 'dd MMM yyyy'
            ));
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\ReservationBundle\Entity\Ticket'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_reservationbundle_ticket';
    }


}
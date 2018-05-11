<?php

namespace LV\ReservationBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use \Symfony\Component\Form\Extension\Core\Type\ChoiceType;

class CommandType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('bookingDate', DateTimeType::class, array(
            'widget' => 'single_text',
            'attr' => ['class' => 'js-datepicker form-control'],
            'html5' => true,
            'format' => 'dd/MM/yyyy'
            
        ))
        ->add('ticketsType', ChoiceType::class, array(
        'choices'  => $this->dayType(),
        'expanded' => true,
         'attr' => array('class' => 'margin'),
        'label_attr' => array('class' => 'margin')
        
            )
        )
        ->add('email', TextType::class)
        ->add('tickets', CollectionType::class, array(
            'entry_type' => TicketType::class,
            'allow_add' => true,
            'allow_delete' => true,
            'by_reference' => false
        ))
        ->add('Enregistrer votre commande', SubmitType::class, array(
            'attr' => ['class' => 'btn btn-secondary my-2 my-sm-0 add-command']
        ))
        ;
    }
    
    public function dayType() {
        //$hour = date('H');
        return array(
        'Journée' => "journée",
        'Demi journée' => "demi journée",
        );
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'LV\ReservationBundle\Entity\Command'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'lv_reservationbundle_command';
    }


}

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
use \Symfony\Component\Validator\Constraints\NotBlank;
use \Symfony\Component\Validator\Constraints\Length;


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
            'label' => 'Tarif réduit (0/N)',
            'attr' => array('class' => 'margin'),
            'label_attr' => array('class' => 'margin')
            ))
        ->add('customerName',  TextType::class, array(
            'label' => 'Nom',
            'attr' => array('class' => 'form-ticket-control'),
            'label_attr' => array(
                'class' => 'control-label',
                'placeholder' => 'Votre nom'
             ),
            'constraints' => array(
                new NotBlank(array(
                    'message' => 'Champ est obligatoire'
                )),
                new Length(array(
                    'min' => 2,
                    'minMessage' => 'Le nom doit comporter plus de 2 cacartères'
                    )),
            ),
            
        ))
        ->add('customerFirstName',  TextType::class, array(
            'label' => 'Prénom',
            'attr' => array('class' => 'form-ticket-control'),
            'label_attr' => array('class' => 'control-label'),
            'constraints' => array(
                new NotBlank(array(
                    'message' => 'Champ est obligatoire'
                )),
                new Length(array(
                    'min' => 2,
                    'minMessage' => 'Le prénom doit comporter plus de 2 cacartères'
                    )),
            ),
        ))
        ->add('customerCountry',  TextType::class, array(
            'label' => 'Pays d\'origine',
            'attr' => array('class' => 'form-ticket-control'),
            'label_attr' => array(
                'class' => 'control-label',
                'placeholder' => 'Votre prénom'
             ),
            'constraints' => array(
                new NotBlank(array(
                    'message' => 'Champ est obligatoire'
                )),
                new Length(array(
                    'min' => 4,
                    'minMessage' => 'Le pays doit comporter plus de 4 cacartères'
                    )),
            ),
        ))
        ->add('customerBirthDate', BirthdayType::class, array(
            'label' => 'Date de naissance',
            'years' => range(date('Y'), 1930),
            'format' => 'dd MMM yyyy',
            'attr' => array('class' => 'margin'),
            'label_attr' => array('class' => 'margin')
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
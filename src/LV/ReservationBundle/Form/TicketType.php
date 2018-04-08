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
        ->add('ticketType', TextType::class, ["label"=>"Type"])
        ->add('rateType',  TextType::class, ["label"=>"Tarif"])
       // ->add('ticketRate',  TextType::class)
        ->add('reducedPrice', CheckboxType::class, array('required' => false), ["label"=>"Tarif réduit (o/n)"])
        ->add('customerName',  TextType::class, ["label"=>"Nom"])
        ->add('customerFirstName',  TextType::class, ["label"=>"Prénom"])
        ->add('customerCountry',  TextType::class, ["label"=>"Pays"])
        ->add('customerBirthDate', BirthdayType::class, ["label"=>"Date de naissance"]);
       // ->add('command');
    }
    /**
     * $builder
      ->add('date',      DateTimeType::class)
      ->add('title',     TextType::class)
      ->add('author',    TextType::class)
      ->add('content',   TextareaType::class)
      ->add('image',     ImageType::class)
      ->add('categories', EntityType::class, array(
        'class'         => 'OCPlatformBundle:Category',
        'choice_label'  => 'name',
        'multiple'      => true,
        'query_builder' => function(CategoryRepository $repository) use($pattern) {
          return $repository->getLikeQueryBuilder($pattern);
        }
      ))
      ->add('save',      SubmitType::class)
    ;
     */
    
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

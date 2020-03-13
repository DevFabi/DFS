<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NominationDenominationInstructeurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
         ->add('evenInstructeur', TextType::class, array(
        'mapped' => false))
        ->add('id',IntegerType::class, array(
            'required' => false))
            ->add('pilote', PilotForModalType::Class, array(
                'label' => false
            ))
        ->add('dateNomination',DateType::class, array(
              'widget' => 'single_text'))
        ->add('dateFinTheo',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false))
        ->add('suspension1Debut',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false))
        ->add('suspension1Fin',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
            'required' => false))
        ->add('suspension2Debut',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('suspension2Fin',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('suspension3Debut',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('suspension3Fin',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('suspension4Debut',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
               'required' => false))
        ->add('suspension4Fin',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('suspension5Debut',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
               'required' => false))
        ->add('suspension5Fin',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy',
              'required' => false))
        ->add('prorogation');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\NominationDenominationInstructeur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_nominationdenominationinstructeur';
    }


}

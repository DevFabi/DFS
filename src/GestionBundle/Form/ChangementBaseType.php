<?php

namespace GestionBundle\Form;

use GestionBundle\Entity\Base;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ChangementBaseType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('pilote', PilotForModalType::Class, array(
            'label' => false
        ))
        ->add('nouvelleBase', EntityType::class, array( 'class'=> Base::Class, 
            'multiple' => false, 
            'expanded' => true,
            'choice_label' => 'abreviationBase'
    ))
        ->add('dateChangement',DateType::class, array(
              'widget' => 'single_text'));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\ChangementBase'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_changementbase';
    }


}

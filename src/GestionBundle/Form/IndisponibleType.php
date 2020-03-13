<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use GestionBundle\Entity\Indisponible;

class IndisponibleType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('evenIndisponible', TextType::class, array('mapped' => false))
        ->add('idindispo', TextType::class, array('mapped' => false,
            'required' => false
        ))
        
        ->add('pilote', PilotForModalType::Class, array(
            'label' => false
        ))
        ->add('dateDebut',DateType::class, array(
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ))
        ->add('dateFin',DateType::class, array (
            'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        )
        )
        ->add('commentaire')
        ->add('aSurveiller')
        ->add('gererPar');
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\Indisponible'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_indisponible';
    }


}

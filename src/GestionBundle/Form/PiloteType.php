<?php

namespace GestionBundle\Form;

use GestionBundle\Entity\Pilote;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PiloteType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('matricule')
        ->add('civilite')
        ->add('nom')
        ->add('prenom')
        ->add('dateNaissance',DateType::class, array(
    'widget' => 'single_text'))
        ->add('age')
        ->add('ageAnnee')
        ->add('dteEntreeAf',DateType::class, array(
    'widget' => 'single_text'))
        ->add('lCP')
        ->add('jrsCadreParAn')
        ->add('role')
        ->add('base')
        ->add('fonction')
        ->add('flotte')
         ->add('Valider',   SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\Pilote',
            'empty_data' => new Pilote()
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'Gestionbundle_pilote';
    }


}

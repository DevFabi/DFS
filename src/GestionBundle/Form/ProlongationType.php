<?php

namespace GestionBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ProlongationType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        
        ->remove('civilite')
         ->remove('nom')
          ->remove('prenom')
          ->remove('jrsCadreParAn')
         ->remove('dateNaissance',DateType::class, array(
     'widget' => 'single_text'))
         ->remove('age')
         ->remove('ageAnnee')
         ->remove('dteEntreeAf',DateType::class, array(
     'widget' => 'single_text'))
         ->remove('lCP')
         ->remove('dteFCSReelle',DateType::class, array(
     'widget' => 'single_text'))
         ->remove('dteFCSTheo',DateType::class, array(
     'widget' => 'single_text'))
         ->remove('ageAuFCS')
         ->remove('dteFinMandatTheo',DateType::class, array(
     'widget' => 'single_text'))
         ->remove('role')
         ->remove('base')
         ->remove('flotte')
         ->remove('fonction')
         ->remove('prorogation')
         ->remove('dteNominationINS',DateType::class, array(
     'widget' => 'single_text'))
       
        ->add('prolong61')
        ->add('prolong62')
        ->add('prolong63')
        ->add('prolong64')
        ->add('prolong65')
          ->add('Valider',   SubmitType::class);
    }/**
     * {@inheritdoc}
     */
    public function getParent()
   {
     return PiloteType::class;
   }
 


}

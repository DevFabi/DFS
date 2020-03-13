<?php

namespace GestionBundle\Form;

use GestionBundle\Entity\Base;
use GestionBundle\Entity\Flotte;
use GestionBundle\Entity\Fonction;
use GestionBundle\Entity\Pilote;
use GestionBundle\Entity\Role;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\ChoiceList\View\ChoiceListView;

class FiltrepType extends AbstractType {
 /**
     * {@inheritdoc}
     */
public function buildForm(FormBuilderInterface $builder, array $options)
{
  
  
 
   // var_dump($options['data'][0]); exit;
   
        $builder->add('base', EntityType::class, array( 'class'=> Base::Class, 
            'multiple' => true, 
            'expanded' => true,
            'choice_label' => 'abreviationBase'
    ))
        ->add('flotte', EntityType::class, array( 'class'=> Flotte::Class, 
            'multiple' => true, 
            'expanded' => true,

    ))
    ->add('fonction', ChoiceType::class, array(
        'choices'  => $options['data'][1],
    ))  

    ->add('role', ChoiceType::class, array(
        'choices'  => $options['data'][0],
    ))  
        
    ->add('prolong61', CheckboxType::class, array(
        'label'    => '61',
        'required' => false,
    ))
    ->add('prolong62', CheckboxType::class, array(
        'label'    => '62',
        'required' => false,
    ))
    ->add('prolong63', CheckboxType::class, array(
        'label'    => '63',
        'required' => false,
    ))
    ->add('prolong64', CheckboxType::class, array(
        'label'    => '64',
        'required' => false,
    ))
    ->add('prolong65', CheckboxType::class, array(
        'label'    => '65',
        'required' => false,
    ))
        ->add('Valider',   SubmitType::class);
}




}

<?php

namespace GestionBundle\Form;

use GestionBundle\Entity\Pilote;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;

class ChoixPiloteType extends AbstractType {
 /**
     * {@inheritdoc}
     */
public function buildForm(FormBuilderInterface $builder, array $options)
{

        $builder->add('pilote', EntityType::class, array( 'class'=> Pilote::Class, 
            'multiple' => true, 
            'expanded' => true,
    ));
}



}

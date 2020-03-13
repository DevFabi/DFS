<?php

namespace GestionBundle\Form;

use GestionBundle\Entity\Flotte;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class pretInterSecteurType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('evenpis', TextType::class, array(
            'mapped' => false))
            ->add('idpis',IntegerType::class, array(
                'mapped' => false,
                'required' => false))
                ->add('pilote', PilotForModalType::Class, array(
                    'label' => false
                ))
        ->add('dateDebutPret',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ))
        ->add('dateFinPret',DateType::class, array(
              'widget' => 'single_text',
            'format' => 'dd/MM/yyyy'
        ))
       
        ->add('flotteDestination',EntityType::class, array(
              'class'=> Flotte::Class));
    }/**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\pretInterSecteur'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_pretintersecteur';
    }


}

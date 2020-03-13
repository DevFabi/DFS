<?php

namespace GestionBundle\Form;

use Doctrine\ORM\EntityRepository;
use GestionBundle\Entity\Fonction;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\OptionsResolver\OptionsResolver;
class NominationDenominationCadreType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
        ->add('evenCadre', TextType::class, array('mapped' => false))
        
        ->add('id',IntegerType::class, array(
            'required' => false))
        ->add('pilote', PilotForModalType::Class, array(
            'label' => false
        ))
        ->add('dateNomination',DateType::class, array(
              'widget' => 'single_text'))
        ->add('dateDenomination',DateType::class, array(
              'widget' => 'single_text',
              'html5' => false,
              'format' => 'dd/MM/yyyy'))
        ->add('nbJourAn')
        ->add('nouvelleFonction',EntityType::class, array(
              'class'=> Fonction::Class,
               'multiple' => false, 
            'expanded' => true,
               'query_builder' => function (EntityRepository $er) {
                 return $er->createQueryBuilder('f')
                 ->where('f.typeFonction LIKE :key')
                 ->orWhere('f.typeFonction LIKE :key2')
                 ->setParameters(array('key' => '%pilote%',
                                  'key2' => '%mission%' ));
    },
                 'choice_label' => 'typeFonction'));
         
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'GestionBundle\Entity\NominationDenominationCadre'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'gestionbundle_nominationdenominationcadre';
    }

   


}

<?php
namespace GestionBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GestionBundle\Entity\Fonction;
class LoadFonctionData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
       

     

        $fonction = new Fonction();
        $fonction->setTypeFonction("Charge de mission");
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('TRI-OPL');
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('TRI-CDB');
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('100%');
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('Stagiaire');
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('Manager pilote');
        $manager->persist($fonction);
        
        $fonction = new Fonction();
        $fonction->setTypeFonction('Indisponible');
        $manager->persist($fonction);
        
        $fonction = new Fonction();
        $fonction->setTypeFonction('Pret intersecteur');
        $manager->persist($fonction);
        
        $fonction = new Fonction();
        $fonction->setTypeFonction('Chef Pilote');
        $manager->persist($fonction);
        
        $fonction = new Fonction();
        $fonction->setTypeFonction('Expert Pilote');
        $manager->persist($fonction);

        $fonction = new Fonction();
        $fonction->setTypeFonction('Cadre');
        $manager->persist($fonction);
        $manager->flush();
    }
}
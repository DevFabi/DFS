<?php
namespace GestionBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GestionBundle\Entity\Base;
class LoadBaseData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $base = new Base();
        $base->setId_base('1');
        $base->setTypeBase('Paris');
         $base->setNomCourtBase('P');
         $base->setAbreviationBase('PAR');
        $manager->persist($base);

        $base = new Base();
        $base->setId_base('2');
        $base->setTypeBase('Marseille');
        $base->setAbreviationBase('MRS');
        $base->setNomCourtBase('M');
        $manager->persist($base);

        $base = new Base();
        $base->setId_base('3');
        $base->setTypeBase('Nice');
        $base->setAbreviationBase('NCE');
         $base->setNomCourtBase('N');
        $manager->persist($base);

        $base = new Base();
        $base->setId_base('4');
        $base->setTypeBase('Toulouse');
        $base->setNomCourtBase('T');
        $base->setAbreviationBase('TLS');
        $manager->persist($base);

        $base = new Base();
        $base->setId_base('5');
        $base->setTypeBase('Ajaccio');
        $base->setAbreviationBase('AJC');
         $base->setNomCourtBase('A');
        $manager->persist($base);

        $base = new Base();
        $base->setId_base('6');
        $base->setTypeBase('Pointe-A-Pitre');
        $base->setAbreviationBase('PTP');
         $base->setNomCourtBase('TO');
        $manager->persist($base);

        $manager->flush();
    }
}
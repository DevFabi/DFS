<?php
namespace GestionBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GestionBundle\Entity\Flotte;
class LoadFlotteData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $flotte = new Flotte();
        $flotte->setId_flotte('1');
        $flotte->setTypeFlotte('A330');
        $manager->persist($flotte);

        $flotte = new Flotte();
        $flotte->setId_flotte('2');
        $flotte->setTypeFlotte('A340');
        $manager->persist($flotte);

        $flotte = new Flotte();
        $flotte->setId_flotte('3');
        $flotte->setTypeFlotte('A350');
        $manager->persist($flotte);

        $flotte = new Flotte();
        $flotte->setId_flotte('4');
        $flotte->setTypeFlotte('A380');
        $manager->persist($flotte);

        $flotte = new Flotte();
        $flotte->setId_flotte('5');
        $flotte->setTypeFlotte('B777');
        $manager->persist($flotte);

        $flotte = new Flotte();
        $flotte->setId_flotte('6');
        $flotte->setTypeFlotte('B787');
        $manager->persist($flotte);

        $manager->flush();
    }
}
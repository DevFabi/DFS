<?php
namespace GestionBundle\DataFixtures\ORM;
use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use GestionBundle\Entity\Role;
class LoadRoleData implements FixtureInterface
{
    public function load(ObjectManager $manager)
    {
        

        $role = new Role();
        $role->setId_role('1');
        $role->setTyperole('CDB');
        $manager->persist($role);

        $role = new Role();
        $role->setId_role('2');
        $role->setTyperole('OPL');
        $manager->persist($role);

        $manager->flush();
    }
}
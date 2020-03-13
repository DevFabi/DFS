<?php

namespace GestionBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use GestionBundle\Entity\Base;
use GestionBundle\Entity\Fonction;
use GestionBundle\Entity\Flotte;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * Role
 *
 * @ORM\Table(name="role")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\RoleRepository")
 */
class Role
{

public function __toString() {
    return $this->typeRole;
}

  /**
     * @var $pilote
     *
     * @ORMOneToMany(targetEntity="Pilote", mappedBy="role", cascade={"persist", "remove", "merge"})
     */

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_role;

    /**
     * @var string
     *
     * @ORM\Column(name="typeRole", type="string", length=255)
     */
    private $typeRole;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
    public function setId_role($id_role)
    {
        return $this->id = $id_role;
        return $this;
    }

    /**
     * Set typeRole
     *
     * @param string $typeRole
     *
     * @return Role
     */
    public function setTypeRole($typeRole)
    {
        $this->typeRole = $typeRole;

        return $this;
    }

    /**
     * Get typeRole
     *
     * @return string
     */
    public function getTypeRole()
    {
        return $this->typeRole;
    }

    /**
     * Get idRole
     *
     * @return integer
     */
    public function getIdRole()
    {
        return $this->id_role;
    }


}

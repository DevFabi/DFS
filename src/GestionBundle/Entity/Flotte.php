<?php

namespace GestionBundle\Entity;
use Doctrine\ORM\Mapping as ORM;
use GestionBundle\Entity\Role;
use GestionBundle\Entity\Base;
use GestionBundle\Entity\Fonction;
use GestionBundle\Entity\Flotte;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
/**
 * Flotte
 *
 * @ORM\Table(name="flotte")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\FlotteRepository")
 */
class Flotte
{
public function __toString() {
    return $this->typeFlotte;
}


    /**
     * @var $pilote
     *
     * @ORMOneToMany(targetEntity="Pilote", mappedBy="flotte", cascade={"persist", "remove", "merge"})
     */

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_flotte;

    /**
     * @var string
     *
     * @ORM\Column(name="typeFlotte", type="string", length=255)
     */
    private $typeFlotte;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    public function setId_flotte($id_flotte)
    {
        return $this->id = $id_flotte;
        return $this;
    }

    /**
     * Set typeFlotte
     *
     * @param string $typeFlotte
     *
     * @return Flotte
     */
    public function setTypeFlotte($typeFlotte)
    {
        $this->typeFlotte = $typeFlotte;

        return $this;
    }

    /**
     * Get typeFlotte
     *
     * @return string
     */
    public function getTypeFlotte()
    {
        return $this->typeFlotte;
    }

    /**
     * Get idFlotte
     *
     * @return integer
     */
    public function getIdFlotte()
    {
        return $this->id_flotte;
    }


}

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
 * Base
 *
 * @ORM\Table(name="base")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\BaseRepository")
 */
class Base
{

    public function __toString() {
    return $this->typeBase;
}

 /**
     * @var $pilote
     *
     * @ORMOneToMany(targetEntity="Pilote", mappedBy="base", cascade={"persist", "remove", "merge"})
     */

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_base;

    /**
     * @var string
     *
     * @ORM\Column(name="typeBase", type="string", length=255)
     */
    private $typeBase;
    /**
     * @var string
     *
     * @ORM\Column(name="nomCourtBase", type="string", length=255)
     */
    private $nomCourtBase;
     /**
     * @var string
     *
     * @ORM\Column(name="abreviationBase", type="string", length=255)
     */
    private $abreviationBase;


 
    public function setId_base($id_base)
    {
        return $this->id = $id_base;
        return $this;
    }
    /**
     * Set typeBase
     *
     * @param string $typeBase
     *
     * @return Base
     */
    public function setTypeBase($typeBase)
    {
        $this->typeBase = $typeBase;

        return $this;
    }

    /**
     * Get typeBase
     *
     * @return string
     */
    public function getTypeBase()
    {
        return $this->typeBase;
    }

    /**
     * Get idBase
     *
     * @return integer
     */
    public function getIdBase()
    {
        return $this->id_base;
    }

    /**
     * Set nomCourtBase
     *
     * @param string $nomCourtBase
     *
     * @return Base
     */
    public function setNomCourtBase($nomCourtBase)
    {
        $this->nomCourtBase = $nomCourtBase;

        return $this;
    }

    /**
     * Get nomCourtBase
     *
     * @return string
     */
    public function getNomCourtBase()
    {
        return $this->nomCourtBase;
    }

      /**
     * Set abreviationBase
     *
     * @param string $abreviationBase
     *
     * @return Base
     */
    public function setAbreviationBase($abreviationBase)
    {
        $this->abreviationBase = $abreviationBase;

        return $this;
    }

    /**
     * Get abreviationBase
     *
     * @return string
     */
    public function getAbreviationBase()
    {
        return $this->abreviationBase;
    }

}

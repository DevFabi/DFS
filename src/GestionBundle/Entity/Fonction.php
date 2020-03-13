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
 * Fonction
 *
 * @ORM\Table(name="fonction")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\FonctionRepository")
 */
class Fonction
{
    public function __toString() {
    return $this->typeFonction;
}


    /**
     * @var $pilote
     *
     * @ORMOneToMany(targetEntity="Pilote", mappedBy="fonction", cascade={"persist", "remove", "merge"})
     */
    
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_fonction;

    /**
     * @var string
     *
     * @ORM\Column(name="typeFonction", type="string", length=255)
     */
    private $typeFonction;


    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }
        public function setId_fonction($id_fonction)
    {
        return $this->id = $id_fonction;
        return $this;
    }

    /**
     * Set typeFonction
     *
     * @param string $typeFonction
     *
     * @return Fonction
     */
    public function setTypeFonction($typeFonction)
    {
        $this->typeFonction = $typeFonction;

        return $this;
    }

    /**
     * Get typeFonction
     *
     * @return string
     */
    public function getTypeFonction()
    {
        return $this->typeFonction;
    }

    /**
     * Get idFonction
     *
     * @return integer
     */
    public function getIdFonction()
    {
        return $this->id_fonction;
    }



    /**
     * Get pilotes
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPilotes()
    {
        return $this->pilotes;
    }
}

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
 * ChangementBase
 *
 * @ORM\Table(name="changement_base")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\ChangementBaseRepository")
 */
class ChangementBase
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateChangement", type="date")
     */
    private $dateChangement;

    /**
     * @var Base $base
     * @ManyToOne(targetEntity="Base")
     * @JoinColumn(name="idAncienneBase", referencedColumnName="id")
     */
    private $ancienneBase;

    /**
     * @var Base $base
     * @ManyToOne(targetEntity="Base")
     * @JoinColumn(name="idNouvelleBase", referencedColumnName="id")
     */
    private $nouvelleBase;

    /**
     * @var Pilote $pilote 
     * @ManyToOne(targetEntity="Pilote",
     inversedBy="changementBases")
     * @JoinColumn(name="id_pilote", referencedColumnName="id")
     */
    private $pilote;





    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set dateChangement
     *
     * @param \DateTime $dateChangement
     *
     * @return ChangementBase
     */
    public function setDateChangement($dateChangement)
    {
        $this->dateChangement = $dateChangement;

        return $this;
    }

    /**
     * Get dateChangement
     *
     * @return \DateTime
     */
    public function getDateChangement()
    {
        return $this->dateChangement;
    }

    /**
     * Set ancienneBase
     *
     * @param string $ancienneBase
     *
     * @return ChangementBase
     */
    public function setAncienneBase($ancienneBase)
    {
        $this->ancienneBase = $ancienneBase;

        return $this;
    }

    /**
     * Get ancienneBase
     *
     * @return string
     */
    public function getAncienneBase()
    {
        return $this->ancienneBase;
    }

    /**
     * Set nouvelleBase
     *
     * @param \GestionBundle\Entity\Base $nouvelleBase
     *
     * @return ChangementBase
     */
    public function setNouvelleBase(\GestionBundle\Entity\Base $nouvelleBase = null)
    {
        $this->nouvelleBase = $nouvelleBase;

        return $this;
    }

    /**
     * Get nouvelleBase
     *
     * @return \GestionBundle\Entity\Base
     */
    public function getNouvelleBase()
    {
        return $this->nouvelleBase;
    }

    /**
     * Set pilote
     *
     * @param \GestionBundle\Entity\Pilote $pilote
     *
     * @return ChangementBase
     */
    public function setPilote(\GestionBundle\Entity\Pilote $pilote = null)
    {
        $this->pilote = $pilote;

        return $this;
    }

    /**
     * Get pilote
     *
     * @return \GestionBundle\Entity\Pilote
     */
    public function getPilote()
    {
        return $this->pilote;
    }
}

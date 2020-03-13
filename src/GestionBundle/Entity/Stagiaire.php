<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Stagiaire
 *
 * @ORM\Table(name="stagiaire")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\StagiaireRepository")
 */
class Stagiaire
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
     * @ORM\Column(name="dateDebut", type="datetime")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="datetime")
     */
    private $dateFin;
    
    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Pilote", inversedBy="stagiaires")
     * @ORM\JoinColumn(name="pilote_id", referencedColumnName="id")
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
     * Set dateDebut
     *
     * @param \DateTime $dateDebut
     *
     * @return Stagiaire
     */
    public function setDateDebut($dateDebut)
    {
        $this->dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Get dateDebut
     *
     * @return \DateTime
     */
    public function getDateDebut()
    {
        return $this->dateDebut;
    }

    /**
     * Set dateFin
     *
     * @param \DateTime $dateFin
     *
     * @return Stagiaire
     */
    public function setDateFin($dateFin)
    {
        $this->dateFin = $dateFin;

        return $this;
    }

    /**
     * Get dateFin
     *
     * @return \DateTime
     */
    public function getDateFin()
    {
        return $this->dateFin;
    }
    
    /**
     * Set pilote
     *
     * @param \GestionBundle\Entity\Pilote $pilote
     *
     * @return Stagiaire
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


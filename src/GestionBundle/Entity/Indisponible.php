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
 * Indisponible
 *
 * @ORM\Table(name="indisponible")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\IndisponibleRepository")
 */
class Indisponible
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
     * @ORM\Column(name="dateDebut", type="date")
     */
    private $dateDebut;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFin", type="date")
     */
    private $dateFin;

    /**
     * @var string
     *
     * @ORM\Column(name="commentaire", type="text", nullable=true)
     */
    private $commentaire;

    /**
     * @var bool
     *
     * @ORM\Column(name="aSurveiller", type="boolean" ,nullable=true)
     */
    private $aSurveiller;
    
    /**
     * @var bool
     *
     * @ORM\Column(name="gererPar", type="boolean" ,nullable=true)
     */
    private $gererPar;
    


    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Pilote", inversedBy="indisponibles")
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
     * @return Indisponible
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
     * @return Indisponible
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
     * Set commentaire
     *
     * @param string $commentaire
     *
     * @return Indisponible
     */
    public function setCommentaire($commentaire)
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    /**
     * Get commentaire
     *
     * @return string
     */
    public function getCommentaire()
    {
        return $this->commentaire;
    }

    /**
     * Set aSurveiller
     *
     * @param boolean $aSurveiller
     *
     * @return Indisponible
     */
    public function setASurveiller($aSurveiller)
    {
        $this->aSurveiller = $aSurveiller;

        return $this;
    }

    /**
     * Get aSurveiller
     *
     * @return bool
     */
    public function getASurveiller()
    {
        return $this->aSurveiller;
    }

    /**
     * Set pilote
     *
     * @param \GestionBundle\Entity\Pilote $pilote
     *
     * @return Indisponible
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

    /**
     * Set gererPar
     *
     * @param boolean $gererPar
     *
     * @return Indisponible
     */
    public function setGererPar($gererPar)
    {
        $this->gererPar = $gererPar;

        return $this;
    }

    /**
     * Get gererPar
     *
     * @return boolean
     */
    public function getGererPar()
    {
        return $this->gererPar;
    }
}

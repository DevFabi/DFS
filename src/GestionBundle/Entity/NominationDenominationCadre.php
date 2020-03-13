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
 * NominationDenominationCadre
 *
 * @ORM\Table(name="nomination_denomination_cadre")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\NominationDenominationCadreRepository")
 */
class NominationDenominationCadre
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
     * @ORM\Column(name="dateNomination", type="date")
     */
    private $dateNomination;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateDenomination", type="date")
     */
    private $dateDenomination;

    /**
     * @var int
     *
     * @ORM\Column(name="nbJourAn", type="integer")
     */
    private $nbJourAn;

    /**
     * @var Fonction $fonction
     * @ManyToOne(targetEntity="Fonction")
     * @JoinColumn(name="id_fonctionAncienne", referencedColumnName="id", nullable=true)
     */
    private $ancienneFonction;

    /**
     * @var Fonction $fonction
     * @ManyToOne(targetEntity="Fonction")
     * @JoinColumn(name="id_fonctionNouvelle", referencedColumnName="id", nullable=true)
     */
    private $nouvelleFonction;

/**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Pilote", inversedBy="nominationDenominationCadres")
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
     * Set id
     *
     * @param integer $id
     *
     * @return NominationDenominationCadre
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Set dateNomination
     *
     * @param \DateTime $dateNomination
     *
     * @return NominationDenominationCadre
     */
    public function setDateNomination($dateNomination)
    {
        $this->dateNomination = $dateNomination;

        return $this;
    }

    /**
     * Get dateNomination
     *
     * @return \DateTime
     */
    public function getDateNomination()
    {
        return $this->dateNomination;
    }

    /**
     * Set nbJourAn
     *
     * @param integer $nbJourAn
     *
     * @return NominationDenominationCadre
     */
    public function setNbJourAn($nbJourAn)
    {
        $this->nbJourAn = $nbJourAn;

        return $this;
    }

    /**
     * Get nbJourAn
     *
     * @return int
     */
    public function getNbJourAn()
    {
        return $this->nbJourAn;
    }

    /**
     * Set ancienneFonction
     *
     * @param \GestionBundle\Entity\Fonction $ancienneFonction
     *
     * @return NominationDenominationCadre
     */
    public function setAncienneFonction(\GestionBundle\Entity\Fonction $ancienneFonction = null)
    {
        $this->ancienneFonction = $ancienneFonction;

        return $this;
    }

    /**
     * Get ancienneFonction
     *
     * @return \GestionBundle\Entity\Fonction
     */
    public function getAncienneFonction()
    {
        return $this->ancienneFonction;
    }

    /**
     * Set nouvelleFonction
     *
     * @param \GestionBundle\Entity\Fonction $nouvelleFonction
     *
     * @return NominationDenominationCadre
     */
    public function setNouvelleFonction(\GestionBundle\Entity\Fonction $nouvelleFonction = null)
    {
        $this->nouvelleFonction = $nouvelleFonction;

        return $this;
    }

    /**
     * Get nouvelleFonction
     *
     * @return \GestionBundle\Entity\Fonction
     */
    public function getNouvelleFonction()
    {
        return $this->nouvelleFonction;
    }

    /**
     * Set pilote
     *
     * @param \GestionBundle\Entity\Pilote $pilote
     *
     * @return NominationDenominationCadre
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
     * Set dateDenomination
     *
     * @param \DateTime $dateDenomination
     *
     * @return NominationDenominationCadre
     */
    public function setDateDenomination($dateDenomination)
    {
        $this->dateDenomination = $dateDenomination;

        return $this;
    }

    /**
     * Get dateDenomination
     *
     * @return \DateTime
     */
    public function getDateDenomination()
    {
        return $this->dateDenomination;
    }
}

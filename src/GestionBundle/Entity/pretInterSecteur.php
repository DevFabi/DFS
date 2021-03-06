<?php

namespace GestionBundle\Entity;
use GestionBundle\Entity\Role;
use GestionBundle\Entity\Base;
use GestionBundle\Entity\Fonction;
use GestionBundle\Entity\Flotte;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\ORM\Mapping as ORM;
/**
 * pretInterSecteur
 *
 * @ORM\Table(name="pret_inter_secteur")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\pretInterSecteurRepository")
 */
class pretInterSecteur
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
     * @ORM\Column(name="dateDebutPret", type="date")
     */
    private $dateDebutPret;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFinPret", type="date")
     */
    private $dateFinPret;

    /**
     * @var Flotte $flotte
     * @ManyToOne(targetEntity="Flotte")
     * @JoinColumn(name="idflotteOrigine", referencedColumnName="id")
     */
    private $flotteOrigine;

    /**
     * @var Flotte $flotte
     * @ManyToOne(targetEntity="Flotte")
     * @JoinColumn(name="idflotteDestination", referencedColumnName="id")
     */
    private $flotteDestination;

    /**
     * @ORM\ManyToOne(targetEntity="GestionBundle\Entity\Pilote", inversedBy="pretInterSecteurs")
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
     * Set dateDebutPret
     *
     * @param \DateTime $dateDebutPret
     *
     * @return pretInterSecteur
     */
    public function setDateDebutPret($dateDebutPret)
    {
        $this->dateDebutPret = $dateDebutPret;

        return $this;
    }

    /**
     * Get dateDebutPret
     *
     * @return \DateTime
     */
    public function getDateDebutPret()
    {
        return $this->dateDebutPret;
    }

    /**
     * Set dateFinPret
     *
     * @param \DateTime $dateFinPret
     *
     * @return pretInterSecteur
     */
    public function setDateFinPret($dateFinPret)
    {
        $this->dateFinPret = $dateFinPret;

        return $this;
    }

    /**
     * Get dateFinPret
     *
     * @return \DateTime
     */
    public function getDateFinPret()
    {
        return $this->dateFinPret;
    }

    /**
     * Set flotteOrigine
     *
     * @param \GestionBundle\Entity\Flotte $flotteOrigine
     *
     * @return pretInterSecteur
     */
    public function setFlotteOrigine(\GestionBundle\Entity\Flotte $flotteOrigine = null)
    {
        $this->flotteOrigine = $flotteOrigine;

        return $this;
    }

    /**
     * Get flotteOrigine
     *
     * @return \GestionBundle\Entity\Flotte
     */
    public function getFlotteOrigine()
    {
        return $this->flotteOrigine;
    }

    /**
     * Set flotteDestination
     *
     * @param \GestionBundle\Entity\Flotte $flotteDestination
     *
     * @return pretInterSecteur
     */
    public function setFlotteDestination(\GestionBundle\Entity\Flotte $flotteDestination = null)
    {
        $this->flotteDestination = $flotteDestination;

        return $this;
    }

    /**
     * Get flotteDestination
     *
     * @return \GestionBundle\Entity\Flotte
     */
    public function getFlotteDestination()
    {
        return $this->flotteDestination;
    }

    /**
     * Set pilote
     *
     * @param \GestionBundle\Entity\Pilote $pilote
     *
     * @return pretInterSecteur
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

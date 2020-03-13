<?php

namespace GestionBundle\Entity;
use GestionBundle\Entity\Role;
use GestionBundle\Entity\Base;
use GestionBundle\Entity\Fonction;
use GestionBundle\Entity\Flotte;
use Doctrine\ORM\Mapping\ManyToOne;
use Doctrine\ORM\Mapping\JoinColumn;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * Pilote
 *
 * @ORM\Table(name="pilote")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\PiloteRepository")
 */
class Pilote 
{
public function __toString() {
    return $this->matricule.' '.$this->nom.' '.$this->prenom;
}

     public function __construct(){
          $this->changementBases = new ArrayCollection();
          $this->indisponibles = new ArrayCollection();
          $this->stagiaires = new ArrayCollection();
          $this->nominationDenominationCadres = new ArrayCollection();
          $this->nominationDenominationInstructeurs = new ArrayCollection();
          $this->pretInterSecteurs = new ArrayCollection();
    }

    /**
     * @var Fonction $fonction
     * @ManyToOne(targetEntity="Fonction")
     * @JoinColumn(name="id_fonction", referencedColumnName="id")
     */
    private $fonction;

    /**
     * @var Flotte $flotte
     * @ManyToOne(targetEntity="Flotte")
     * @JoinColumn(name="id_flotte", referencedColumnName="id")
     */
    private $flotte;

    /**
     * @var Base $base
     * @ManyToOne(targetEntity="Base")
     * @JoinColumn(name="id_base", referencedColumnName="id")
     */
    private $base;

     /**
     * @var Role $role 
     * @ManyToOne(targetEntity="Role")
     * @JoinColumn(name="id_role", referencedColumnName="id")
     */
    private $role;


    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\pretInterSecteur", mappedBy="pilote")
     */
    private $pretInterSecteurs;

    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\NominationDenominationInstructeur", mappedBy="pilote" )
     */
    private $nominationDenominationInstructeurs;

    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\ChangementBase", mappedBy="pilote")
     */
    private $changementBases;

    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\Indisponible", mappedBy="pilote")
     */
    private $indisponibles;
    /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\Stagiaire", mappedBy="pilote")
     */
    private $stagiaires;

        /**
     * @ORM\OneToMany(targetEntity="GestionBundle\Entity\NominationDenominationCadre", mappedBy="pilote")
     */
    private $nominationDenominationCadres;


    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id_pilote;

    /**
     * @var string
     *
     * @ORM\Column(name="matricule", type="string", length=255)
     */
    private $matricule;

    /**
     * @var string
     *
     * @ORM\Column(name="civilite", type="string", length=255)
     */
    private $civilite;

    /**
     * @var string
     *
     * @ORM\Column(name="nom", type="string", length=255, nullable=true)
     */
    private $nom;

    /**
     * @var string
     *
     * @ORM\Column(name="prenom", type="string", length=255)
     */
    private $prenom;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="date_naissance", type="date" , nullable=true)
     */
    private $dateNaissance;

    /**
     * @var float
     *
     * @ORM\Column(name="age", type="float", nullable=true)
     */
    private $age;

    /**
     * @var int
     *
     * @ORM\Column(name="age_annee", type="integer", nullable=true)
     */
    private $ageAnnee;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dte_entree_af", type="date" , nullable=true)
     */
    private $dteEntreeAf;

    /**
     * @var int
     *
     * @ORM\Column(name="LCP", type="integer", nullable=true)
     */
    private $lCP;

    /**
     * @var int
     *
     * @ORM\Column(name="jrs_cadre_par_an", type="integer" ,nullable=true)
     */
    private $jrsCadreParAn;

 
/**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFCStheorique", type="date", nullable=true)
     */
    private $dateFCStheorique;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="dateFCSreelle", type="date", nullable=true)
     */
    private $dateFCSreelle;

    /**
     * @var bool
     *
     * @ORM\Column(name="prolong61", type="boolean", nullable=true)
     */
    private $prolong61;
        /**
     * @var bool
     *
     * @ORM\Column(name="prolong62", type="boolean",nullable=true)
     */
    private $prolong62;
        /**
     * @var bool
     *
     * @ORM\Column(name="prolong63", type="boolean",nullable=true)
     */
    private $prolong63;

        /**
     * @var bool
     *
     * @ORM\Column(name="prolong64", type="boolean",nullable=true)
     */
    private $prolong64;
        /**
     * @var bool
     *
     * @ORM\Column(name="prolong65", type="boolean",nullable=true)
     */
    private $prolong65;

    /**
     * @var bool
     *
     * @ORM\Column(name="finalFCS", type="boolean",nullable=true)
     */
    private $finalFCS;



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
     * Set matricule
     *
     * @param string $matricule
     *
     * @return Pilote
     */
    public function setMatricule($matricule)
    {
        $this->matricule = $matricule;

        return $this;
    }

    /**
     * Get matricule
     *
     * @return string
     */
    public function getMatricule()
    {
        return $this->matricule;
    }

    /**
     * Set civilite
     *
     * @param string $civilite
     *
     * @return Pilote
     */
    public function setCivilite($civilite)
    {
        $this->civilite = $civilite;

        return $this;
    }

    /**
     * Get civilite
     *
     * @return string
     */
    public function getCivilite()
    {
        return $this->civilite;
    }

    /**
     * Set nom
     *
     * @param string $nom
     *
     * @return Pilote
     */
    public function setNom($nom)
    {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Get nom
     *
     * @return string
     */
    public function getNom()
    {
        return $this->nom;
    }

    /**
     * Set prenom
     *
     * @param string $prenom
     *
     * @return Pilote
     */
    public function setPrenom($prenom)
    {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Get prenom
     *
     * @return string
     */
    public function getPrenom()
    {
        return $this->prenom;
    }

    /**
     * Set dateNaissance
     *
     * @param \DateTime $dateNaissance
     *
     * @return Pilote
     */
    public function setDateNaissance($dateNaissance)
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    /**
     * Get dateNaissance
     *
     * @return \DateTime
     */
    public function getDateNaissance()
    {
        return $this->dateNaissance;
    }

    /**
     * Set age
     *
     * @param float $age
     *
     * @return Pilote
     */
    public function setAge($age)
    {
        $this->age = $age;

        return $this;
    }

    /**
     * Get age
     *
     * @return float
     */
    public function getAge()
    {
        return $this->age;
    }

    /**
     * Set ageAnnee
     *
     * @param integer $ageAnnee
     *
     * @return Pilote
     */
    public function setAgeAnnee($ageAnnee)
    {
        $this->ageAnnee = $ageAnnee;

        return $this;
    }

    /**
     * Get ageAnnee
     *
     * @return int
     */
    public function getAgeAnnee()
    {
        return $this->ageAnnee;
    }

    /**
     * Set dteEntreeAf
     *
     * @param \DateTime $dteEntreeAf
     *
     * @return Pilote
     */
    public function setDteEntreeAf($dteEntreeAf)
    {
        $this->dteEntreeAf = $dteEntreeAf;

        return $this;
    }

    /**
     * Get dteEntreeAf
     *
     * @return \DateTime
     */
    public function getDteEntreeAf()
    {
        return $this->dteEntreeAf;
    }

    /**
     * Set lCP
     *
     * @param integer $lCP
     *
     * @return Pilote
     */
    public function setLCP($lCP)
    {
        $this->lCP = $lCP;

        return $this;
    }

    /**
     * Get lCP
     *
     * @return int
     */
    public function getLCP()
    {
        return $this->lCP;
    }

   

    /**
     * Set jrsCadreParAn
     *
     * @param integer $jrsCadreParAn
     *
     * @return Pilote
     */
    public function setJrsCadreParAn($jrsCadreParAn)
    {
        $this->jrsCadreParAn = $jrsCadreParAn;

        return $this;
    }

    /**
     * Get jrsCadreParAn
     *
     * @return int
     */
    public function getJrsCadreParAn()
    {
        return $this->jrsCadreParAn;
    }

    
    /**
     * Set dteFinMandatTheo
     *
     * @param \DateTime $dteFinMandatTheo
     *
     * @return Pilote
     */
    public function setDteFinMandatTheo($dteFinMandatTheo)
    {
        $this->dteFinMandatTheo = $dteFinMandatTheo;

        return $this;
    }

    /**
     * Get dteFinMandatTheo
     *
     * @return \DateTime
     */
    public function getDteFinMandatTheo()
    {
        return $this->dteFinMandatTheo;
    }


    /**
     * Get idPilote
     *
     * @return integer
     */
    public function getIdPilote()
    {
        return $this->id_pilote;
    }



    /**
     * Add changementBase
     *
     * @param \GestionBundle\Entity\ChangementBase $changementBase
     *
     * @return Pilote
     */
    public function addChangementBase(\GestionBundle\Entity\ChangementBase $changementBase)
    {
        $this->changementBases[] = $changementBase;

        return $this;
    }

    /**
     * Remove changementBase
     *
     * @param \GestionBundle\Entity\ChangementBase $changementBase
     */
    public function removeChangementBase(\GestionBundle\Entity\ChangementBase $changementBase)
    {
        $this->changementBases->removeElement($changementBase);
    }

    /**
     * Get changementBases
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChangementBases()
    {
        return $this->changementBases;
    }

   

    /**
     * Add pretInterSecteur
     *
     * @param \GestionBundle\Entity\pretInterSecteur $pretInterSecteur
     *
     * @return Pilote
     */
    public function addPretInterSecteur(\GestionBundle\Entity\pretInterSecteur $pretInterSecteur)
    {
        $this->pretInterSecteurs[] = $pretInterSecteur;

        return $this;
    }

    /**
     * Remove pretInterSecteur
     *
     * @param \GestionBundle\Entity\pretInterSecteur $pretInterSecteur
     */
    public function removePretInterSecteur(\GestionBundle\Entity\pretInterSecteur $pretInterSecteur)
    {
        $this->pretInterSecteurs->removeElement($pretInterSecteur);
    }

    /**
     * Get pretInterSecteurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPretInterSecteurs()
    {
        return $this->pretInterSecteurs;
    }

    /**
     * Add nominationDenominationInstructeur
     *
     * @param \GestionBundle\Entity\NominationDenominationInstructeur $nominationDenominationInstructeur
     *
     * @return Pilote
     */
    public function addNominationDenominationInstructeur(\GestionBundle\Entity\NominationDenominationInstructeur $nominationDenominationInstructeur)
    {
        $this->nominationDenominationInstructeurs[] = $nominationDenominationInstructeur;

        return $this;
    }

    /**
     * Remove nominationDenominationInstructeur
     *
     * @param \GestionBundle\Entity\NominationDenominationInstructeur $nominationDenominationInstructeur
     */
    public function removeNominationDenominationInstructeur(\GestionBundle\Entity\NominationDenominationInstructeur $nominationDenominationInstructeur)
    {
        $this->nominationDenominationInstructeurs->removeElement($nominationDenominationInstructeur);
    }

    /**
     * Get nominationDenominationInstructeurs
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNominationDenominationInstructeurs()
    {
        return $this->nominationDenominationInstructeurs;
    }

    /**
     * Add indisponible
     *
     * @param \GestionBundle\Entity\Indisponible $indisponible
     *
     * @return Pilote
     */
    public function addIndisponible(\GestionBundle\Entity\Indisponible $indisponible)
    {
        $this->indisponibles[] = $indisponible;

        return $this;
    }

    /**
     * Remove indisponible
     *
     * @param \GestionBundle\Entity\Indisponible $indisponible
     */
    public function removeIndisponible(\GestionBundle\Entity\Indisponible $indisponible)
    {
        $this->indisponibles->removeElement($indisponible);
    }

    /**
     * Get indisponibles
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getIndisponibles()
    {
        return $this->indisponibles;
    }

    /**
     * Add nominationDenominationCadre
     *
     * @param \GestionBundle\Entity\NominationDenominationCadre $nominationDenominationCadre
     *
     * @return Pilote
     */
    public function addNominationDenominationCadre(\GestionBundle\Entity\NominationDenominationCadre $nominationDenominationCadre)
    {
        $this->nominationDenominationCadres[] = $nominationDenominationCadre;

        return $this;
    }

    /**
     * Remove nominationDenominationCadre
     *
     * @param \GestionBundle\Entity\NominationDenominationCadre $nominationDenominationCadre
     */
    public function removeNominationDenominationCadre(\GestionBundle\Entity\NominationDenominationCadre $nominationDenominationCadre)
    {
        $this->nominationDenominationCadres->removeElement($nominationDenominationCadre);
    }

    /**
     * Get nominationDenominationCadres
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getNominationDenominationCadres()
    {
        return $this->nominationDenominationCadres;
    }

    /**
     * Set fonction
     *
     * @param \GestionBundle\Entity\Fonction $fonction
     *
     * @return Pilote
     */
    public function setFonction(\GestionBundle\Entity\Fonction $fonction = null)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return \GestionBundle\Entity\Fonction
     */
    public function getFonction()
    {
        return $this->fonction;
    }

    /**
     * Set flotte
     *
     * @param \GestionBundle\Entity\Flotte $flotte
     *
     * @return Pilote
     */
    public function setFlotte(\GestionBundle\Entity\Flotte $flotte = null)
    {
        $this->flotte = $flotte;

        return $this;
    }

    /**
     * Get flotte
     *
     * @return \GestionBundle\Entity\Flotte
     */
    public function getFlotte()
    {
        return $this->flotte;
    }

    /**
     * Set base
     *
     * @param \GestionBundle\Entity\Base $base
     *
     * @return Pilote
     */
    public function setBase(\GestionBundle\Entity\Base $base = null)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return \GestionBundle\Entity\Base
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set role
     *
     * @param \GestionBundle\Entity\Role $role
     *
     * @return Pilote
     */
    public function setRole(\GestionBundle\Entity\Role $role = null)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return \GestionBundle\Entity\Role
     */
    public function getRole()
    {
        return $this->role;
    }

    

    /**
     * Set dateFCStheorique
     *
     * @param \DateTime $dateFCStheorique
     *
     * @return Pilote
     */
    public function setDateFCStheorique($dateFCStheorique)
    {
        $this->dateFCStheorique = $dateFCStheorique;

        return $this;
    }

    /**
     * Get dateFCStheorique
     *
     * @return \DateTime
     */
    public function getDateFCStheorique()
    {
        return $this->dateFCStheorique;
    }

    /**
     * Set dateFCSreelle
     *
     * @param \DateTime $dateFCSreelle
     *
     * @return Pilote
     */
    public function setDateFCSreelle($dateFCSreelle)
    {
        $this->dateFCSreelle = $dateFCSreelle;

        return $this;
    }

    /**
     * Get dateFCSreelle
     *
     * @return \DateTime
     */
    public function getDateFCSreelle()
    {
        return $this->dateFCSreelle;
    }

    /**
     * Set prolong61
     *
     * @param boolean $prolong61
     *
     * @return Pilote
     */
    public function setProlong61($prolong61)
    {
        $this->prolong61 = $prolong61;

        return $this;
    }

    /**
     * Get prolong61
     *
     * @return boolean
     */
    public function getProlong61()
    {
        return $this->prolong61;
    }

    /**
     * Set prolong62
     *
     * @param boolean $prolong62
     *
     * @return Pilote
     */
    public function setProlong62($prolong62)
    {
        $this->prolong62 = $prolong62;

        return $this;
    }

    /**
     * Get prolong62
     *
     * @return boolean
     */
    public function getProlong62()
    {
        return $this->prolong62;
    }

    /**
     * Set prolong63
     *
     * @param boolean $prolong63
     *
     * @return Pilote
     */
    public function setProlong63($prolong63)
    {
        $this->prolong63 = $prolong63;

        return $this;
    }

    /**
     * Get prolong63
     *
     * @return boolean
     */
    public function getProlong63()
    {
        return $this->prolong63;
    }

    /**
     * Set prolong64
     *
     * @param boolean $prolong64
     *
     * @return Pilote
     */
    public function setProlong64($prolong64)
    {
        $this->prolong64 = $prolong64;

        return $this;
    }

    /**
     * Get prolong64
     *
     * @return boolean
     */
    public function getProlong64()
    {
        return $this->prolong64;
    }

    /**
     * Set prolong65
     *
     * @param boolean $prolong65
     *
     * @return Pilote
     */
    public function setProlong65($prolong65)
    {
        $this->prolong65 = $prolong65;

        return $this;
    }

    /**
     * Get prolong65
     *
     * @return boolean
     */
    public function getProlong65()
    {
        return $this->prolong65;
    }

    /**
     * Set finalFCS
     *
     * @param boolean $finalFCS
     *
     * @return Pilote
     */
    public function setFinalFCS($finalFCS)
    {
        $this->finalFCS = $finalFCS;

        return $this;
    }

    /**
     * Get finalFCS
     *
     * @return boolean
     */
    public function getFinalFCS()
    {
        return $this->finalFCS;
    }
    
    
    /**
     * Add stagiaire
     *
     * @param \GestionBundle\Entity\Stagiaire $stagiaire
     *
     * @return Pilote
     */
    public function addStagiaire(\GestionBundle\Entity\Stagiaire $stagiaire)
    {
        $this->stagiaires[] = $stagiaire;
        
        return $this;
    }
    
    /**
     * Remove stagiaire
     *
     * @param \GestionBundle\Entity\Stagiaire $stagiaire
     */
    public function removeStagiaire(\GestionBundle\Entity\Stagiaire $stagiaire)
    {
        $this->stagiaires->removeElement($stagiaire);
    }
    
    /**
     * Get stagiaires
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getStagiaires()
    {
        return $this->stagiaires;
    }
}

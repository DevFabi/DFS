<?php

namespace GestionBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Compteur
 *
 * @ORM\Table(name="compteur")
 * @ORM\Entity(repositoryClass="GestionBundle\Repository\CompteurRepository")
 */
class Compteur
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
     * @var int
     *
     * @ORM\Column(name="annee", type="integer")
     */
    private $annee;

    /**
     * @var int
     *
     * @ORM\Column(name="mois", type="integer")
     */
    private $mois;
    
    /**
     * @var string
     *
     * @ORM\Column(name="base", type="string")
     */
    private $base;

    /**
     * @var string
     *
     * @ORM\Column(name="flotte", type="string")
     */
    private $flotte;
    
    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string")
     */
    private $role;
    
    /**
     * @var string
     *
     * @ORM\Column(name="fonction", type="string")
     */
    private $fonction;

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
     * Set annee
     *
     * @param integer $annee
     *
     * @return Compteur
     */
    public function setAnnee($annee)
    {
        $this->annee = $annee;

        return $this;
    }

    /**
     * Get annee
     *
     * @return int
     */
    public function getAnnee()
    {
        return $this->annee;
    }

    /**
     * Set mois
     *
     * @param integer $mois
     *
     * @return Compteur
     */
    public function setMois($mois)
    {
        $this->mois = $mois;

        return $this;
    }

    /**
     * Get mois
     *
     * @return int
     */
    public function getMois()
    {
        return $this->mois;
    }

    /**
     * Set base
     *
     * @param string $base
     *
     * @return Compteur
     */
    public function setBase($base)
    {
        $this->base = $base;

        return $this;
    }

    /**
     * Get base
     *
     * @return string
     */
    public function getBase()
    {
        return $this->base;
    }

    /**
     * Set flotte
     *
     * @param string $flotte
     *
     * @return Compteur
     */
    public function setFlotte($flotte)
    {
        $this->flotte = $flotte;

        return $this;
    }

    /**
     * Get flotte
     *
     * @return string
     */
    public function getFlotte()
    {
        return $this->flotte;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Compteur
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set fonction
     *
     * @param string $fonction
     *
     * @return Compteur
     */
    public function setFonction($fonction)
    {
        $this->fonction = $fonction;

        return $this;
    }

    /**
     * Get fonction
     *
     * @return string
     */
    public function getFonction()
    {
        return $this->fonction;
    }
}

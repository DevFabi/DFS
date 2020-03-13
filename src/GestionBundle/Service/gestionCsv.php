<?php

namespace GestionBundle\Service;

use GestionBundle\Entity\Indisponible;
use GestionBundle\Entity\NominationDenominationInstructeur;
use GestionBundle\Entity\NominationDenominationCadre;
use GestionBundle\Entity\Pilote;
use DateTime;
use GestionBundle\Entity\Stagiaire;

class gestionCsv {
    
    private $em;
    
    public function __construct(\Doctrine\ORM\EntityManager $em) {
        $this->em = $em;
    }
    
    // Cherche si le pilote existe et fait les actions en fonction [ AJOUT pilote, AJOUT evenement ]
    public function ifPiloteExist($ArrayOfCsv) {
        
        // Parcours du tb csv
        foreach ($ArrayOfCsv as $csvRow) {
            
            $csvMatricule = $csvRow['Matricule'];
            
            //récupération des infos de bases
            $flotte = $this->em->getRepository('GestionBundle:Flotte')->findOneBy(array('typeFlotte' => $csvRow['Flotte']));
            $base = $this->em->getRepository('GestionBundle:Base')->findOneBy(array('typeBase' => $csvRow['Base']));
            $fonction = $this->em->getRepository('GestionBundle:Fonction')->findOneBy(array('typeFonction' => $csvRow['Fonction']));
            $role = $this->em->getRepository('GestionBundle:Role')->findOneBy(array('typeRole' => $csvRow['Rôle']));
            
            //check si un pilote avec meme matricule eiste deja ou pas
            $pilote = $this->em->getRepository('GestionBundle:Pilote')->findOneBy(array('matricule' => $csvMatricule));
            
            //si il n'existe pas
            if ($pilote == null) {
                //on le crée et on lui attribut les données de bases
                
                $pilote = new Pilote();
                $pilote->setRole($role);
                $pilote->setBase($base);
                $pilote->setFonction($fonction);
                $pilote->setFlotte($flotte);
                $pilote->setMatricule($csvMatricule);
                $pilote->setNom($csvRow['NOM']);
                $pilote->setPrenom($csvRow['Prenom']);
                if ($csvRow['Dte_naissance'] != null) {
                    $pilote->setDateNaissance(\DateTime::createFromFormat('d/m/Y', $csvRow['Dte_naissance']));
                }
                if ($csvRow['Dte_entrée_AF'] != null) {
                    $pilote->setDteEntreeAf(\DateTime::createFromFormat('d/m/Y', $csvRow['Dte_entrée_AF']));
                }
                if ($csvRow['LCP'] != null && $csvRow['LCP'] != "#N/A") {
                    $pilote->setLCP($csvRow['LCP']);
                }
                
                $this->em->persist($pilote);
                $this->em->flush();
            }
            
            //on est désormais sur que le pilote existe bien
            //on lui ajoute la fonction
            $convertedDateDebEvt = \DateTime::createFromFormat('d/m/Y', $csvRow['Dte_deb_evt']);
            $convertedDateFinEvt = \DateTime::createFromFormat('d/m/Y', $csvRow['Dte_fin_evt']);
            switch ($csvRow['Fonction']) {
                case "FCS":
                    $pilote->setDateFCStheorique($convertedDateDebEvt);
                    break;
                case "Indisponible":
                    // Regarder si l'indispo n'existe pas deja
                    $indispoExit = $this->em->getRepository('GestionBundle:Indisponible')->getEventIndisponibleWithDate($convertedDateDebEvt, $convertedDateFinEvt, $pilote);
                    if ($indispoExit == null || $indispoExit <= 0) {
                        // Sinon creer l'evenement indisponible
                        $Indisponible = new Indisponible();
                        $Indisponible->setPilote($pilote);
                        $Indisponible->setDateDebut($convertedDateDebEvt);
                        $Indisponible->setDateFin($convertedDateFinEvt);
                        $this->em->persist($Indisponible);
                        $this->em->flush();
                        $pilote->setFonction($fonction);
                    }
                    break;
                case "Stagiaire":
                    // Regarder si l'indispo n'existe pas deja
                    $stagiaireExit = $this->em->getRepository('GestionBundle:Stagiaire')->getEventStagiaireWithDate($convertedDateDebEvt, $convertedDateFinEvt, $pilote);
                    if ($stagiaireExit == null || $stagiaireExit <= 0) {
                        // Sinon creer l'evenement stagiaire
                        $stagiaire = new Stagiaire();
                        $stagiaire->setPilote($pilote);
                        $stagiaire->setDateDebut($convertedDateDebEvt);
                        $stagiaire->setDateFin($convertedDateFinEvt);
                        $this->em->persist($stagiaire);
                        $this->em->flush();
                        $pilote->setFonction($fonction);
                    }
                    break;
                case "TRI-CDB":
                case "TRI-OPL":
                    // Regarder si l'evenement instructeur n'existe pas deja
                    $instructeurExit = $this->em->getRepository('GestionBundle:NominationDenominationInstructeur')->getEventInstructeurWithDate($convertedDateDebEvt, $convertedDateFinEvt, $pilote);
                    if ($instructeurExit == null || $instructeurExit <= 0) {
                        // Sinon creer l'evenement instructeur
                        $NominationDenominationInstructeur = new NominationDenominationInstructeur();
                        $NominationDenominationInstructeur->setPilote($pilote);
                        $NominationDenominationInstructeur->setDateNomination($convertedDateDebEvt);
                        $NominationDenominationInstructeur->setDateFinTheo($convertedDateFinEvt);
                        $NominationDenominationInstructeur->setNouvelleFonction($fonction);
                        $this->em->persist($NominationDenominationInstructeur);
                        $this->em->flush();
                        $pilote->setFonction($fonction);
                        break;
                    }
                case "Cadre Hors Division":
                case "Cadre en Division":
                case "Manager Pilote":
                case "Chef pilote":
                case "Expert Pilote":
                case "Chargé de mission":
                    // Regarder si l'evenement cadre n'existe pas deja
                    $cadreExit = $this->em->getRepository('GestionBundle:NominationDenominationCadre')->getEventCadreWithDate($convertedDateDebEvt, $convertedDateFinEvt, $pilote);
                    if ($cadreExit == null || $cadreExit <= 0) {
                        // Sinon creer l'evenement cadre
                        $NominationDenominationCadre = new NominationDenominationCadre();
                        $NominationDenominationCadre->setPilote($pilote);
                        $NominationDenominationCadre->setnbJourAn(0);
                        $NominationDenominationCadre->setDateNomination($convertedDateDebEvt);
                        $NominationDenominationCadre->setDateDenomination($convertedDateFinEvt);
                        $NominationDenominationCadre->setNouvelleFonction($fonction);
                        $this->em->persist($NominationDenominationCadre);
                        $this->em->flush();
                        if ($csvRow['Fonction'] == "Cadre Hors Division" || $csvRow['Fonction'] == "Cadre en Division"){
                            $fonctionC = $this->em->getRepository('GestionBundle:Fonction')->findOneBy(array('typeFonction' => "Cadre"));
                            $pilote->setFonction($fonctionC);
                        }else{
                            $pilote->setFonction($fonction); }
                    }
                    
                    break;
                case "100%" :
                    $pilote->setFonction($fonction);
                    break;
                    
            }
            $this->em->persist($pilote);
            $this->em->flush();
        }
    }
    
}

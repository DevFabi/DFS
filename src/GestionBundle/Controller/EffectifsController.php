<?php

namespace GestionBundle\Controller;

use GestionBundle\Entity\ChangementBase;
use GestionBundle\Entity\Indisponible;
use GestionBundle\Entity\NominationDenominationCadre;
use GestionBundle\Entity\NominationDenominationInstructeur;
use GestionBundle\Entity\Pilote;
use GestionBundle\Entity\pretInterSecteur;
use GestionBundle\Form\ChangementBaseType;
use GestionBundle\Form\ChoixPiloteType;
use GestionBundle\Form\FCSType;
use GestionBundle\Form\FiltrepType;
use GestionBundle\Form\IndisponibleType;
use GestionBundle\Form\NominationDenominationCadreType;
use GestionBundle\Form\NominationDenominationInstructeurType;
use GestionBundle\Form\ProlongationType;
use GestionBundle\Form\SearchPiloteType;
use GestionBundle\Form\pretInterSecteurType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use DateInterval;
use DateTimeImmutable;
use GestionBundle\Entity\Flotte;
use GestionBundle\Entity\Base;
use GestionBundle\Service\FileUploader;
use GestionBundle\Service\SearchEvent;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;


class EffectifsController extends Controller {
    
    public function effectifsAction(Request $request) {
        $em = $this->container->get('doctrine')->getEntityManager();
        $pilotes = $em->getRepository('GestionBundle:Pilote')->findAll();
        
        // On récupère les services necessaires pour le CSV
        $ConvertCsvToArray = $this->get('gestion_bundle.ConvertCsvToArray');
        $GestionCsv = $this->get('gestion_bundle.gestionCsv');
        
        // Creation du formulaire d'envois de fichier csv
        $importForm = $this->createFormBuilder()
        ->add('submitFile', FileType::class, array('label' => 'File to Submit'))
        ->add('valider', SubmitType::class)->getForm();
        $importForm->handleRequest($request);
        
        
        /* ------------------------------------ IMPORTATION FICHIER CSV------------------------------------ */
        /* ------------------------------------------------------------------------------------------------ */
       
        // Recuperation des données et traduction en array via le service 'ConvertCsvToArray'
          if ($importForm->isSubmitted() && $importForm->isValid()) {
                $filename = $importForm->get('submitFile')->getData();
                $ArrayOfCsv = $ConvertCsvToArray->convert($filename,$delimiter = ';');
                $GestionCsv = $GestionCsv->ifPiloteExist($ArrayOfCsv);
          }
            
        
       

        // Formulaire de filtre 
         $roles = $em->getRepository('GestionBundle:Role')->findAll();
         $fonctions = $em->getRepository('GestionBundle:Fonction')->findAll();
         
         // Creation du tb pour les libellés des roles
         $tbrole= array();
         $tbrole["All Roles"] = "All Roles";
         foreach ($roles as $role){
             $tbrole[$role->getTypeRole()] = $role->getIdRole();
         }   
         // Creation du tb pour les libellés des fonctions
         $tbfonction= array();
         $tbfonction["All Fonctions"] = "All Fonctions";
         $tbfonction["All Cadres"] = "All Cadres";
         foreach ($fonctions as $fonction){
             $tbfonction[$fonction->getTypeFonction()] = $fonction->getIdFonction();
         }
         // Tb qui regroupe les deux tb pour envoyer en parametre au formType FiltrepType
         $tbRoleFonction = array();
         $tbRoleFonction[] = $tbrole;
         $tbRoleFonction[] = $tbfonction;
         
         $filtreForm = $this->createForm(FiltrepType::class, $tbRoleFonction);
        
        // Formulaire "Contrôles de l'interface" :: matricule et nom
        $searchPilote = new Pilote();
        $form = $this->createForm(SearchPiloteType::class, $searchPilote);
        
        
             /* ------------------------- Chargement des formulaires d'action ---------------------- */
        
        
        /* -------------------------- Formulaire nomination / denomination cadre-------------------------- */
        /* ----------------------------------------------------------------------------------------------- */
    
        $NominationDenominationCadre = new NominationDenominationCadre();
        $NominationDenominationCadreForm = $this->createForm(NominationDenominationCadreType::class);
        $NominationDenominationCadreForm->handleRequest($request);
        
        if ($NominationDenominationCadreForm->isSubmitted() && $NominationDenominationCadreForm->isValid()) {
            /* On recupere le pilote grace a son matricule */
            $matricule = $NominationDenominationCadreForm->get('pilote')["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            
            /* On recupere les donnees envoyees au form */
            $evenCadre = $NominationDenominationCadreForm->get('evenCadre')->getData();
            $nouvelleFonction = $NominationDenominationCadreForm["nouvelleFonction"]->getData();
            $ancienneFonction = $pilote[0]->getFonction();
            $jrsCadreParAn = $NominationDenominationCadreForm["nbJourAn"]->getData();
            $dateNomination = $NominationDenominationCadreForm["dateNomination"]->getData();
            $dateDenomination = $NominationDenominationCadreForm["dateDenomination"]->getData();
            $idndcadre = $NominationDenominationCadreForm["id"]->getData();
            
            
            /* ------------------- TRAITEMENT :: SI LE PILOTE N'EST PAS CADRE A TODAY :: Creation ------------------- */
            /* Mettre sa date FCS THEO en date denomination */
            if ($evenCadre == 0 || $evenCadre == "isFalse") {
                $dateDenomination = $pilote[0]->getDateFCStheorique();
                $NominationDenominationCadre->setDateDenomination($dateDenomination);
            }
            
            /* ------------------------ TRAITEMENT :: SI LE PILOTE EST CADRE A TODAY ----------------------- */
            if ($evenCadre == "isTrue") {
                /* On recupere le bon evenement grace a l'id */
                $ndCadre = $em->getRepository('GestionBundle:NominationDenominationCadre')->findById($idndcadre);
                /* On recupere la date de denomination saisie */
                $ndCadre[0]->setDateDenomination($NominationDenominationCadreForm["dateDenomination"]->getData());
                /* Puis on modifie juste la nouvelle date ( qui remplace la date FCS theo ) */
                $em->persist($ndCadre[0]);
                $em->flush();
                $this->addFlash('notice', "Date de denomination cadre bien mise a jour");
                return $this->redirectToRoute('effectifs');
            }
            
            
            /* Erreur si la date de denomination est inferieure a la date de nomination */
            if ($dateNomination > $dateDenomination) {
                $this->addFlash('warning', "La date de nomination est plus grande que la date de denomination");
                return $this->redirectToRoute('effectifs');
            }
            if ($dateNomination != null) {
                // On récupère le service
                $SearchEvent = $this->get('gestion_bundle.SearchEvent');
                // Service qui recherche si un evenement a lieu en meme temps
                $searchDoubleEvent = $SearchEvent->doubleEvent($pilote[0],$dateNomination);
               
                if(!$searchDoubleEvent){ // S'il n'y a pas d'evenement en meme temps on peut créer le nouveau
                $NominationDenominationCadre->setPilote($pilote[0]);
                $NominationDenominationCadre->setDateNomination($dateNomination);
                $NominationDenominationCadre->setDateDenomination($dateDenomination);
                $NominationDenominationCadre->setNbJourAn($jrsCadreParAn);
                $NominationDenominationCadre->setAncienneFonction($ancienneFonction);
                $NominationDenominationCadre->setNouvelleFonction($nouvelleFonction);
                
                $em = $this->getDoctrine()->getManager();
                $em->persist($NominationDenominationCadre);
                $em->flush();
                
                $this->addFlash('notice', "Nomination Denomination cadre bien mise a jour"); }
                
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            
            return $this->redirectToRoute('effectifs');
        }
        
        
        /* -------------------------- Formulaire nomination / denomination instructeur -------------------------- */
        /* ------------------------------------------------------------------------------------------------------ */
        
        $NominationDenominationInstructeur = new NominationDenominationInstructeur();
        $NominationDenominationInstructeurForm = $this->createForm(NominationDenominationInstructeurType::class, $NominationDenominationInstructeur);
        $NominationDenominationInstructeurForm->handleRequest($request);
        
        
        if ($NominationDenominationInstructeurForm->isSubmitted() && $NominationDenominationInstructeurForm->isValid()) {
            $matricule = $NominationDenominationInstructeurForm->get('pilote')["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            
            $evenInstructeur = $NominationDenominationInstructeurForm->get('evenInstructeur')->getData();
            
            // On recupere toutes les données du formulaire soumis
            $dateNomination = $NominationDenominationInstructeurForm["dateNomination"]->getData();
            $dateDenomination = $NominationDenominationInstructeurForm["dateFinTheo"]->getData();
            $sd1 = $NominationDenominationInstructeurForm["suspension1Debut"]->getData();
            $sf1 = $NominationDenominationInstructeurForm["suspension1Fin"]->getData();
            $sd2 = $NominationDenominationInstructeurForm["suspension2Debut"]->getData();
            $sf2 = $NominationDenominationInstructeurForm["suspension2Fin"]->getData();
            $sd3 = $NominationDenominationInstructeurForm["suspension3Debut"]->getData();
            $sf3 = $NominationDenominationInstructeurForm["suspension3Fin"]->getData();
            $sd4 = $NominationDenominationInstructeurForm["suspension4Debut"]->getData();
            $sf4 = $NominationDenominationInstructeurForm["suspension4Fin"]->getData();
            $sd5 = $NominationDenominationInstructeurForm["suspension5Debut"]->getData();
            $sf5 = $NominationDenominationInstructeurForm["suspension5Fin"]->getData();
            $idndins = $NominationDenominationInstructeurForm["id"]->getData();
            $proroge = $NominationDenominationInstructeurForm["prorogation"]->getData();
          
            
            /* ------------------------ TRAITEMENT :: SI LE PILOTE EST INSTRUCTEUR A TODAY ----------------------- */
            
            if ($evenInstructeur == "isTrue") {
                /* On recupere le bon evenement grace a l'id */
                $ndIns = $em->getRepository('GestionBundle:NominationDenominationInstructeur')->findById($idndins);
                
                /* Si la DATE DE FIN DE MANDAT a ete changée */
                if ($dateDenomination != null) {
                    $ndIns[0]->setDateFinTheo($dateDenomination);
                }
                // Si proroge est coché on rajoute un an a la date de denomination
                if ($proroge == "true") {
                    $ndIns[0]->setDateFinTheo($dateDenomination->modify("+ 1 years"));
                    $ndIns[0]->setProrogation($proroge);
                }
                // Conditions pour les suspensions debut et fin
                // Si les champs sont complétés :: faire la modification / l'ajout en bdd
                if ($sd1 != "" && $sf1 != ""){
                $ndIns[0]->setSuspension1Debut($sd1);
                $ndIns[0]->setSuspension1Fin($sf1);}
                    if ($sd2 != "" && $sf2 != ""){
                    $ndIns[0]->setSuspension2Debut($sd2);
                    $ndIns[0]->setSuspension2Fin($sf2);}
                        if ($sd3 != "" && $sf3 != ""){
                        $ndIns[0]->setSuspension3Debut($sd3);
                        $ndIns[0]->setSuspension3Fin($sf3);}
                            if ($sd4 != "" && $sf4 != ""){
                            $ndIns[0]->setSuspension4Debut($sd4);
                            $ndIns[0]->setSuspension4Fin($sf4);}
                                if ($sd5 != "" && $sf5 != ""){
                                $ndIns[0]->setSuspension5Debut($sd5);
                                $ndIns[0]->setSuspension5Fin($sf5);}
                
                /* On modifie dans la bdd */
                $em->persist($ndIns[0]);
                $em->flush();
                $this->addFlash('notice', "Date de denomination instructeur bien mise a jour");
                return $this->redirectToRoute('effectifs');
            }
            
            /* ------------------------ TRAITEMENT :: SI LE PILOTE N'EST PAS INSTRUCTEUR A TODAY :: Creation ------------------------ */
            if ($evenInstructeur != "isTrue") {
                /* On cree la date de fin theo qui correspond a un mandat de 5 ans */
                /* DONC dateNomination + 5 ans = date fin theo */
                $dateDenomination = DateTimeImmutable::createFromMutable($dateNomination);
                $dateDenomination = $dateDenomination->add(new DateInterval('P5Y'));
            }
            
            /* Verification de la date de debut et de la date de fin */
            if ($dateNomination > $dateDenomination || $sd1 > $sf1 || $sd2 > $sf2 || $sd3 > $sf3 || $sd4 > $sf4 || $sd5 > $sf5) {
                $this->addFlash('warning', "La date de debut est plus grande que la date de fin");
                return $this->redirectToRoute('effectifs');
            }
            
            /* Si la date de nomination a bien été rentrée : on procede au traitement */
            if ($dateNomination != null) {
                // Appel du service de recherche d'un evenement sur la meme date
                $SearchEvent = $this->get('gestion_bundle.SearchEvent');
                $searchDoubleEvent = $SearchEvent->doubleEvent($pilote[0],$dateNomination);
                
                if(!$searchDoubleEvent){ // Si aucun evenement existe a la date de debut -> création
                /* Si tous les traitements sont OK : j'insere dans la bdd */
                $NominationDenominationInstructeur->setPilote($pilote[0]);
                $NominationDenominationInstructeur->setDateNomination($dateNomination);
                $NominationDenominationInstructeur->setDateFinTheo($dateDenomination);
                 
                $em = $this->getDoctrine()->getManager();
                $em->persist($NominationDenominationInstructeur);
                $em->flush();
                
                $this->addFlash('notice', "Nomination Denomination instructeur bien crée"); }
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            return $this->redirectToRoute('effectifs');
        }
        
        /* --------------------------        Formulaire Changement de base      -------------------------- */
        /* ----------------------------------------------------------------------------------------------- */
     
        
        $ChangementBase = new ChangementBase();
        $ChangementBaseForm = $this->createForm(ChangementBaseType::class, $ChangementBase);
        $ChangementBaseForm->handleRequest($request);
        
        if ($ChangementBaseForm->isSubmitted() && $ChangementBaseForm->isValid()) {
            // On recupere le pilote grace a son matricule
            $matricule = $ChangementBaseForm->get('pilote')["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            
            // On recupere les données du formulaire soumis
            $ancienneBase = $pilote[0]->getBase();
            $dateChangement = $ChangementBaseForm["dateChangement"]->getData();
            $nouvelleBase = $ChangementBaseForm["nouvelleBase"]->getData();
            
            // Si la date de changement est bien remplie
            if ($dateChangement != null) {
                /* $SearchEvent = $this->get('gestion_bundle.SearchEvent');
                $searchDoubleEvent = $SearchEvent->doubleEvent($pilote[0],$dateChangement); */
                $ChangementBase->setPilote($pilote[0]);
                $ChangementBase->setDateChangement($dateChangement);
                $ChangementBase->setAncienneBase($ancienneBase);
                $ChangementBase->setNouvelleBase($nouvelleBase);
                $em = $this->getDoctrine()->getManager();
                $em->persist($ChangementBase);
                $em->flush();
                
                $this->addFlash('notice', "Changement de base bien mise a jour"); 
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            
            return $this->redirectToRoute('effectifs');
        }

        
        /* -----------------------------        Formulaire Indisponible      ----------------------------- */
        /* ----------------------------------------------------------------------------------------------- */
     
        
        $Indisponible = new Indisponible();
        $IndisponibleForm = $this->createForm(IndisponibleType::class, $Indisponible);
        $IndisponibleForm->handleRequest($request);
        
        if ($IndisponibleForm->isSubmitted() && $IndisponibleForm->isValid()) {
            // On recupere le pilote grace a son matricule
            $matricule = $IndisponibleForm->get('pilote')["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            // On recupere les données du formulaire soumis
            $evenIndispo = $IndisponibleForm->get('evenIndisponible')->getData();
            $dateDebut = $IndisponibleForm["dateDebut"]->getData();
            $dateFin = $IndisponibleForm["dateFin"]->getData();
            $com = $IndisponibleForm["commentaire"]->getData();
            $asurveiller = $IndisponibleForm["aSurveiller"]->getData();
            $gererPar = $IndisponibleForm["gererPar"]->getData();
            $idindispo = $IndisponibleForm["idindispo"]->getData();
            
            /* ------------------------ TRAITEMENT :: SI LE PILOTE EST INDISPONIBLE A TODAY :: Modification ------------------------ */
            if ($evenIndispo == "isTrue" && $idindispo != null){
                /* On recupere le bon evenement grace a l'id */
                $indispoActuelle = $em->getRepository('GestionBundle:Indisponible')->findById($idindispo);
                // On modifie les nouveaux champs
                $indispoActuelle[0]->setDateFin($dateFin);
                $indispoActuelle[0]->setCommentaire($com);
                $indispoActuelle[0]->setASurveiller($asurveiller);
                $indispoActuelle[0]->setGererPar($gererPar);
                $em->persist($indispoActuelle[0]);
                $em->flush();
                $this->addFlash('notice', "Indisponibilité bien mise a jour");
                return $this->redirectToRoute('effectifs');
            }
            /* ------------------------ TRAITEMENT :: SI LE PILOTE N'EST PAS INDISPONIBLE A TODAY :: Creation ------------------------ */
            
            // Verification des dates rentrées
            if ($dateDebut > $dateFin) {
                $this->addFlash('warning', "La date de debut est plus grande que la date de fin");
                return $this->redirectToRoute('effectifs');
            }
            
            // Si la date de debut est bien remplie
            if ($dateDebut != null) {
                // Verification s'il n'y a pas un evenement en meme temps
                $SearchEvent = $this->get('gestion_bundle.SearchEvent');
                $searchDoubleEvent = $SearchEvent->doubleEvent($pilote[0],$dateDebut);
                
                // Si aucun evenement est en conflit on créee l'indisponibilité
                if(!$searchDoubleEvent){
                $Indisponible->setPilote($pilote[0]);
                $Indisponible->setDateDebut($dateDebut);
                $Indisponible->setDateFin($dateFin);
                $Indisponible->setCommentaire($com);
                $Indisponible->setASurveiller($asurveiller);
                $Indisponible->setGererPar($gererPar);
                $em = $this->getDoctrine()->getManager();
                $em->persist($Indisponible);
                $em->flush(); 
                
                $this->addFlash('notice', "Pilote Indisponible bien mis a jour"); }
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }    
            return $this->redirectToRoute('effectifs');
        }
        
        /* --------------------------        Formulaire pret inter secteur      -------------------------- */
        /* ----------------------------------------------------------------------------------------------- */

        $pretInterSecteur = new pretInterSecteur();
        $pretInterSecteurForm = $this->createForm(pretInterSecteurType::class, $pretInterSecteur);
        $pretInterSecteurForm->handleRequest($request);
        
        if ($pretInterSecteurForm->isSubmitted() && $pretInterSecteurForm->isValid()) {
            // On recupere le piltoe grace a son matricule
            $matricule = $pretInterSecteurForm->get('pilote')["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            // On recupere les données du formulaire soumis
            $dateDebutPret = $pretInterSecteurForm['dateDebutPret']->getData();
            $dateFinPret = $pretInterSecteurForm['dateFinPret']->getData();
            $flotteOrigine = $pilote[0]->getFlotte();
            $flotteDestination = $pretInterSecteurForm['flotteDestination']->getData();
            $idpis = $pretInterSecteurForm['idpis']->getData();
            $evenpis = $pretInterSecteurForm['evenpis']->getData();
            
            // --------------  SI LE PILOTE EST INDISPONIBLE A TODAY
            if ($evenpis == "isTrue"){
                /* On recupere le bon evenement grace a l'id */
                $pis = $em->getRepository('GestionBundle:pretInterSecteur')->findById($idpis);
                $pis[0]->setDateFinPret($pretInterSecteurForm["dateFinPret"]->getData());
                // On modifie les données
                $pis[0]->setDateDebutPret($dateDebutPret);
                $pis[0]->setDateFinPret($dateFinPret);
                $pis[0]->setFlotteOrigine($flotteOrigine);
                $pis[0]->setFlotteDestination($flotteDestination);
                $em->persist($pis[0]);
                $em->flush();
                $this->addFlash('notice', "Pret inter secteur bien mise a jour");
                return $this->redirectToRoute('effectifs');
            }
            // Verification des dates
            if ($dateDebutPret > $dateFinPret) {
                $this->addFlash('warning', "La date de debut est plus grande que la date de fin");
                return $this->redirectToRoute('effectifs');
            }
            // Verification des champs
            if ($dateDebutPret != null && $dateFinPret != null && $flotteDestination != null) {
                // Recherche s'il ny a pas deja un evenement a la date de debut de pret
                $SearchEvent = $this->get('gestion_bundle.SearchEvent');
                $searchDoubleEvent = $SearchEvent->doubleEvent($pilote[0],$dateDebutPret);
                // S'il n'y a pas d'evenement :: Creation
                if(!$searchDoubleEvent){
                $pretInterSecteur->setPilote($pilote[0]);
                $pretInterSecteur->setDateDebutPret($dateDebutPret);
                $pretInterSecteur->setDateFinPret($dateFinPret);
                $pretInterSecteur->setFlotteOrigine($flotteOrigine);
                $pretInterSecteur->setFlotteDestination($flotteDestination);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pretInterSecteur);
                $em->flush();
                $this->addFlash('notice', "Pret inter secteur bien mis a jour"); }
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            return $this->redirectToRoute('effectifs');
        }
        
        /* --------------------------            Formulaire prolongation         -------------------------- */
        /* ----------------------------------------------------------------------------------------------- */
        
        $Prolongation = new Pilote();
        $ProlongationForm = $this->createForm(ProlongationType::class, $Prolongation);
        $ProlongationForm->handleRequest($request);
        
        if ($ProlongationForm->isSubmitted() && $ProlongationForm->isValid()) {
            // On recupere le pilote grace a son matricule
            $matricule = $ProlongationForm["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            // On recupere les donnees du formulaire
            $prolong61 = $ProlongationForm["prolong61"]->getData();
            $prolong62 = $ProlongationForm["prolong62"]->getData();
            $prolong63 = $ProlongationForm["prolong63"]->getData();
            $prolong64 = $ProlongationForm["prolong64"]->getData();
            $prolong65 = $ProlongationForm["prolong65"]->getData();
            // Verification des champs
            if ($prolong61 != null || $prolong62 != null || $prolong63 != null || $prolong64 != null || $prolong65 != null) {
                // Modification dans la bdd
                $pilote[0]->setProlong61($prolong61);
                $pilote[0]->setProlong62($prolong62);
                $pilote[0]->setProlong63($prolong63);
                $pilote[0]->setProlong64($prolong64);
                $pilote[0]->setProlong65($prolong65);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pilote[0]);
                $em->flush();
                $this->addFlash('notice', "Prolongation bien mise a jour");
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            
            return $this->redirectToRoute('effectifs');
        }
        
        /* ----------------------------------        Formulaire FCS     ---------------------------------- */
        /* ----------------------------------------------------------------------------------------------- */
        
        $FCS = new Pilote();
        $FCSForm = $this->createForm(FCSType::class, $FCS);
        $FCSForm->handleRequest($request);
        
        if ($FCSForm->isSubmitted() && $FCSForm->isValid()) {
            // On recupere le piltoe grace a son matricle
            $matricule = $FCSForm["matricule"]->getData();
            $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule);
            // On recupere les donnees du formulaire soumis
            $dateFCStheorique = $FCSForm["dateFCStheorique"]->getData();
            $dateFCSreelle = $FCSForm["dateFCSreelle"]->getData();
            
            // Verification des champs
            if ($dateFCStheorique != null) {
                // Modification des dates sur le pilote
                $pilote[0]->setDateFCStheorique($dateFCStheorique);
                $pilote[0]->setDateFCSreelle($dateFCSreelle);
                $em = $this->getDoctrine()->getManager();
                $em->persist($pilote[0]);
                $em->flush();
                $this->addFlash('notice', "FCS bien mis a jour");
            } else {
                $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
            }
            return $this->redirectToRoute('effectifs');
        }
        
        $ChoixForm = $this->createForm(ChoixPiloteType::class);
        return $this->container->get('templating')->renderResponse('GestionBundle::effectifs.html.twig', array(
            'pilotes' => $pilotes,
            'choixForm' => $ChoixForm->createView(),
            'FiltreForm' => $filtreForm->createView(),
            'FCSForm' => $FCSForm->createView(),
            'ProlongationForm' => $ProlongationForm->createView(),
            'pretInterSecteurForm' => $pretInterSecteurForm->createView(),
            'form' => $form->createView(),
            'importForm' => $importForm->createView(),
            'NominationDenominationCadreForm' => $NominationDenominationCadreForm->createView(),
            'IndisponibleForm' => $IndisponibleForm->createView(),
            'ChangementBaseForm' => $ChangementBaseForm->createView(),
            'NominationDenominationInstructeurForm' => $NominationDenominationInstructeurForm->createView()));
    }
    
    
}/* FIN CLASSE */
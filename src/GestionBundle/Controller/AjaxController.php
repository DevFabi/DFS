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


class AjaxController extends Controller {
    /* ---------------------------------    ZONE DE CONTROLE ZONE 3    ---------------------------------  */
    
    public function controleAction(Request $request) {
        
        if ($request->isXmlHttpRequest()) {
            
            // On recupere le matricule et le nom
            $matricule = $request->request->get('matricule');
            $nom = $request->request->get('nom');
            
            $piloteRepository = $this->getDoctrine()->getRepository('GestionBundle:Pilote');
            
            if ($matricule != '' && $nom == '') {
                $qb = $piloteRepository->findByMatricule($matricule);
            } elseif ($matricule == '' && $nom != '') {
                $qb = $piloteRepository->findByNom($nom);
            } else {
                $arrayJson = null;
            }
            
            
            /* Si la requête ne retourne rien on passe le tableau à null */
            if (empty($qb) || is_null($qb)) {
                $arrayJson = null;
                if ($arrayJson = null) {
                    $this->addFlash('warning', "Vous n'avez pas rempli tous les champs");
                }
            } /* elseif($qb > 1){ */ /* Si il y a plusieurs résultats */
            /* On recupere pour chaque pilote trouvé : nom prénom & matricule */
            /* foreach ($qb as $pilote) {
             $mat = $pilote->getMatricule();
             $nom = $pilote->getNom();
             $prenom = $pilote->getPrenom();
             }
             $ChoixForm = $this->createForm(ChoixPiloteType::class);
             $ChoixForm->handleRequest($request);
             if ($ChoixForm->isSubmitted() && $ChoixForm->isValid()) {
             $pilote = $ChoixForm["pilote"]->getData(); */
            /* On recupere la checkbox */
            /* $pilote = $em->getRepository('GestionBundle:Pilote')->findByMatricule($matricule); */ /* On recupere le pilote */
            /* }
             $arrayJson = $pilote; *//* Mettre dans arrayJson le pilote selectionné */
            
            /* } */ else { /* Si la requête retourne une réponse on la met dans $arrayJson */
            
            $arrayJson = $qb;
            $today = new \DateTimeImmutable('now', new \DateTimeZone('Europe/Paris'));
            
            foreach ($arrayJson as $key => $value) {
                
                // --- En COMMENTAIRE car les fichiers csv ne donnent pas de dateFCSReelle
                
                // A ajouter dans le script :: Tous les soirs, si un pilote rempli la condition : setFinalFCS = true
                // RECHERCHE si [TODAY] devient supérieur à [Date FCS réelle] + 4 mois => finalFCS = true
                //$dateFCSreelle = $value->getDateFCSreelle();
                // Je crée une date avec 4 mois supplementaires
                //$dateFCSand4months = DateTimeImmutable::createFromMutable($dateFCSreelle);
                //$dateFCSand4months = $dateFCSand4months->add(new DateInterval('P4M'));
                /*  var_dump($dateFCSreelle->format('d/m/Y')); var_dump($dateFCSand4months->format('d/m/Y')); */
                
               /* if ($today > $dateFCSand4months){
                    $FinalFCS = true;
                }else {
                    $FinalFCS = false;
                }
                */
                
                /* APPEL DES REPOSITORY */
                $ndCadreRepository = $this->getDoctrine()->getRepository('GestionBundle:NominationDenominationCadre');
                $ndInstructeurRepository = $this->getDoctrine()->getRepository('GestionBundle:NominationDenominationInstructeur');
                $indisponibleRepository = $this->getDoctrine()->getRepository('GestionBundle:Indisponible');
                $pisRepository = $this->getDoctrine()->getRepository('GestionBundle:pretInterSecteur');
                
                /* RECHERCHE :: Si un pilote a un evenement a TODAY */
                
                /* NOMINATITON / DENOMINATION D'UN CADRE */
                $dateNomCadre = null;
                $idndcadre = null;
                $evenCadre = 0;
                $dateDenomCadre = null;
                $ndCadre = $ndCadreRepository->getEventCadre($today, $qb[0]->getIdPilote());
                
                if ($ndCadre == null || $ndCadre == "null"){
                    $evenCadre = "isFalse";
                }else {
                    $evenCadre = "isTrue";
                    $dateNomCadre = $ndCadre[0]->getDateNomination();
                    $dateDenomCadre = $ndCadre[0]->getDateDenomination();
                    $idndcadre = $ndCadre[0]->getId();
                }
                
                /* NOMINATITON / DENOMINATION D'UN INSTRUCTEUR */
                $evenInstructeur = 0;
                $idndins = null;
                $date_INS = null;
                $datefinmandat_theo = null;
                $suspension1Debut = null;
                $suspension1Fin = null;
                $suspension2Debut = null;
                $suspension2Fin = null;
                $suspension3Debut = null;
                $suspension3Fin = null;
                $suspension4Debut = null;
                $suspension4Fin = null;
                $suspension5Debut = null;
                $suspension5Fin = null;
                
                $ndInstructeur = $ndInstructeurRepository->getEventInstructeur($today, $qb[0]->getIdPilote());
                if ($ndInstructeur == null || $ndInstructeur == "null"){
                    $evenInstructeur = "isFalse";
                }else { 
                    $evenInstructeur = "isTrue";
                    $datefinmandat_theo = $ndInstructeur[0]->getDateFinTheo();
                    $suspension1Debut = $ndInstructeur[0]->getSuspension1Debut();
                    $suspension1Fin = $ndInstructeur[0]->getSuspension1Fin();
                    $suspension2Debut = $ndInstructeur[0]->getSuspension2Debut();
                    $suspension2Fin = $ndInstructeur[0]->getSuspension2Fin();
                    $suspension3Debut = $ndInstructeur[0]->getSuspension3Debut();
                    $suspension3Fin = $ndInstructeur[0]->getSuspension3Fin();
                    $suspension4Debut = $ndInstructeur[0]->getSuspension4Debut();
                    $suspension4Fin = $ndInstructeur[0]->getSuspension4Fin();
                    $suspension5Debut = $ndInstructeur[0]->getSuspension5Debut();
                    $suspension5Fin = $ndInstructeur[0]->getSuspension5Fin();
                    $date_INS = $ndInstructeur[0]->getDateNomination();
                    $idndins = $ndInstructeur[0]->getId();
                }
                /* PILOTE INDISPONIBLE  */
                $dateDebutIndispo = null;
                $dateFinIndispo = null;
                $idIndispo = null;
                $evenIndisponible = 0;
                $comIndispo = null;
                $gererParIndispo = null;
                $aSurveillerIndispo = null;
                $indispo = $indisponibleRepository->getEventIndisponible($today, $qb[0]->getIdPilote());
                if ($indispo == null || $indispo == "null"){
                    $evenIndisponible = "isFalse";
                }else {
                    $evenIndisponible = "isTrue";
                    $dateDebutIndispo = $indispo[0]->getDateDebut();
                    $dateFinIndispo = $indispo[0]->getDateFin();
                    $comIndispo =$indispo[0]->getCommentaire();
                    $gererParIndispo =$indispo[0]->getGererPar();
                    $aSurveillerIndispo =$indispo[0]->getASurveiller();
                    $idIndispo = $indispo[0]->getId();
                }
                
                /* PRET INTER SECTEUR  */
                $dateDebutPret = null;
                $dateFinPret = null;
                $idpis = null;
                $evenpis = 0;
                $flotteDestination = null;
                $pis = $pisRepository->getEventPis($today, $qb[0]->getIdPilote());
                if ($pis == null || $pis == "null"){
                    $evenpis = "isFalse";
                }else {
                    $evenpis = "isTrue";
                    $dateDebutPret = $pis[0]->getDateDebutPret();
                    $dateFinPret = $pis[0]->getDateFinPret();
                    $idpis = $pis[0]->getId();
                    $flotteDestination =$pis[0]->getFlotteDestination()->getIdFlotte();
                }
                
                $arrayJson = array(
                    'id' => $value->getIdPilote(),
                    'nom' => $value->getNom(),
                    'matricule' => $value->getMatricule(),
                    'role' => $value->getRole()->getTypeRole(),
                    'fonction' => $value->getFonction()->getTypeFonction(),
                    'age' => $value->getAge(),
                    'dn' => is_null($value->getDateNaissance()) ? NULL : $value->getDateNaissance()->format('d/m/Y'),
                    'base' => $value->getBase()->getTypeBase(),
                    'idbase' => $value->getBase()->getIdBase(),
                    'flotte' => $value->getFlotte()->getTypeFlotte(),
                    'entree_af' => is_null($value->getDteEntreeAf()) ? NULL : $value->getDteEntreeAf()->format('d/m/Y'),
                    'LCP' => $value->getLCP(),
                    'dateFCS_theo' => is_null($value->getDateFCStheorique()) ? NULL : $value->getDateFCStheorique()->format('d/m/Y'),
                    'dateFCS_r' => is_null($value->getDateFCSreelle()) ? NULL : $value->getDateFCSreelle()->format('d/m/Y'),
                    'jr_cadre' => $value->getJrsCadreParAn(),
                    'nomination_ins' => is_null($date_INS) ? NULL : $date_INS->format('d/m/Y'),
                    'datefinmandat_theo' => is_null($datefinmandat_theo) ? NULL : $datefinmandat_theo->format('d/m/Y'),
                    'pilote-dateNomination' => is_null($dateNomCadre) ? NULL : $dateNomCadre->format('d/m/Y'),
                    'pilote-dateDenomination' => is_null($dateDenomCadre) ? NULL : $dateDenomCadre->format('d/m/Y'),
                    'prolong61' => $value->getProlong61(),
                    'prolong62' => $value->getProlong62(),
                    'prolong63' => $value->getProlong63(),
                    'prolong64' => $value->getProlong64(),
                    'prolong65' => $value->getProlong65(),
                    'idndcadre' => $idndcadre,
                    'idndins' => $idndins,
                    'idindispo' =>$idIndispo,
                    'dateDebutIndispo'=>is_null($dateDebutIndispo) ? NULL : $dateDebutIndispo->format('d/m/Y'),
                    'dateFinIndispo'=>is_null($dateFinIndispo) ? NULL : $dateFinIndispo->format('d/m/Y'),
                    'comIndispo' => $comIndispo,
                    'gererParIndispo' => $gererParIndispo,
                    'aSurveillerIndispo' => $aSurveillerIndispo,
                    'suspension1Debut' => is_null($suspension1Debut) ? NULL : $suspension1Debut->format('d/m/Y'),
                    'suspension1Fin' => is_null($suspension1Fin) ? NULL : $suspension1Fin->format('d/m/Y'),
                    'suspension2Debut' =>is_null($suspension2Debut) ? NULL :  $suspension2Debut->format('d/m/Y'),
                    'suspension2Fin' => is_null($suspension2Fin) ? NULL : $suspension2Fin->format('d/m/Y'),
                    'suspension3Debut' =>is_null($suspension3Debut) ? NULL :  $suspension3Debut->format('d/m/Y'),
                    'suspension3Fin' => is_null($suspension3Fin) ? NULL : $suspension3Fin->format('d/m/Y'),
                    'suspension4Debut' =>is_null($suspension4Debut) ? NULL :  $suspension4Debut->format('d/m/Y'),
                    'suspension4Fin' => is_null($suspension4Fin) ? NULL : $suspension4Fin->format('d/m/Y'),
                    'suspension5Debut' =>is_null($suspension5Debut) ? NULL :  $suspension5Debut->format('d/m/Y'),
                    'suspension5Fin' => is_null($suspension5Fin) ? NULL : $suspension5Fin->format('d/m/Y'),
                    'evenInstructeur' =>  $evenInstructeur,
                    'evenCadre' => $evenCadre,
                    'evenpis' => $evenpis,
                    'idpis'=> $idpis,
                    'evenIndisponible' => $evenIndisponible,
                    'debutPret' => is_null($dateDebutPret) ? NULL : $dateDebutPret->format('d/m/Y'),
                    'finPret' =>is_null($dateFinPret) ? NULL : $dateFinPret->format('d/m/Y'),
                    'flotteDestination' => $flotteDestination,
                    //'FinalFCS' => $FinalFCS,
                    'prenom' => $value->getPrenom());
                $arrayJson[] = array($arrayJson);
            }
            }
            
            return new Response(json_encode($arrayJson));
        }
    }
    
    /* ---------------------------------    ZONE DE FILTRE ZONE 2    ---------------------------------  */
    
    public function filtreAction(Request $request) {
        
        /* Traitement ajax dans web/ajax.js  -> Premiere fonction */
        
        if ($request->isXmlHttpRequest()) {
            
            $role = $request->request->get('role');
            $fonction = $request->request->get('fonction');
           
            $baseIds = $request->request->get('check_base');
            $flotteIds = $request->request->get('check_flotte');
            $prolong61 = intval($request->request->get('check_prolong1'));
            $prolong62 = intval($request->request->get('check_prolong2'));
            $prolong63 = intval($request->request->get('check_prolong3'));
            $prolong64 = intval($request->request->get('check_prolong4'));
            $prolong65 = intval($request->request->get('check_prolong5'));
            
            /* Base et flotte sont deux tableaux :: Ils contiennent plusieurs valeurs */
            
            // Transformer les id en objet
            // Les id sont des string :: utilisation de intval() pour les passer en int
            $roleRepository = $this->getDoctrine()->getRepository('GestionBundle:Role');
            if (is_numeric($role)){
                $role = $roleRepository->findOneBy(['id_role' => $role]); }
            $fonctionRepository = $this->getDoctrine()->getRepository('GestionBundle:Fonction');
            if (is_numeric($fonction)){
                $fonction = $fonctionRepository->findOneBy(['id_fonction' => $fonction]); }
                if ($fonction == "All Cadres"){
                    $arrayFonctionCadre = array();
                    $arrayFonctionCadre = ["Cadre", "Manager Pilote", "Chef pilote", "Expert Pilote", "Charge de mission"];
                    $fonction = $fonctionRepository->findBy(['typeFonction' => $arrayFonctionCadre]);       
                }
                
            
            if ($baseIds != null) {
                // Passer de string a int l'array
                $arrayBaseIds = implode(',', $baseIds);
                $arrayBaseIds = array_map('intval', explode(',', $arrayBaseIds));
                $baseRepository = $this->getDoctrine()->getRepository('GestionBundle:Base');
                $bases = $baseRepository->findBy(['id_base' => $arrayBaseIds]);
            } else {
                $bases = null;
            }
            
            if ($flotteIds != null){
                $arrayFlotteIds = implode(',', $flotteIds);
                $arrayFlotteIds = array_map('intval', explode(',', $arrayFlotteIds));
                $flotteRepository = $this->getDoctrine()->getRepository('GestionBundle:Flotte');
                $flottes = $flotteRepository->findBy(['id_flotte' => $arrayFlotteIds]);
            }else {     $flottes = null;}
            
            $pilotes = null;
            
            // On appel le repository
            $piloteRepository = $this->getDoctrine()->getRepository('GestionBundle:Pilote');
            $pilotes = $piloteRepository->getAllPilotesByFilters($bases, $role, $fonction, $flottes, $prolong61, $prolong62, $prolong63, $prolong64, $prolong65);
            
            if (is_null($pilotes) || empty($pilotes)) {
                $arrayJson = null;
            } else {
                
                $arrayJson = array();
                $i = 0;
                
                foreach ($pilotes as $pilote) {
                    $name = $pilote->getMatricule() . ' ' . $pilote->getNom() . ' ' . $pilote->getPrenom() . ' ' . $pilote->getRole()->getTypeRole() ;
                    $arrayJson[$i]['name'] = $name;
                    $arrayJson[$i]['desc'] = "";
                    
                    //gestions des indispo
                    $indispos = $pilote->getIndisponibles();
                    $tmpArray = array();
                    
                    $j = 0;
                    foreach ($indispos as $indispo) {
                       
                        /* Remplissage du tableau tmp des indispos  */
                        $tmpArray[$j]['from'] = $indispo->getDateDebut()->format('U000');
                        $tmpArray[$j]['to'] = $indispo->getDateFin()->format('U000'); //date de début dans le Gantt
                        //date de fin dans le Gantt
                        $tmpArray[$j]['label'] = 'Indispo'; //le nom du label dans le gantt
                        $tmpArray[$j]['customClass'] = "ganttIndisponible"; //la couleur du bloc dans le gantt
                        $j++;
                    }
                    //gestions des changement de bases -> Pas d'affichage dans le calendrier
                    /* $switchBases = $pilote->getChangementBases();
                     foreach ($switchBases as $switchBase) {
                     
                     $tmpArray[$j]['to'] = $switchBase->getDateChangement()->format('U000'); //date de début dans le Gantt
                     $tmpArray[$j]['from'] = $switchBase->getDateChangement()->format('U000'); //date de fin dans le Gantt
                     $tmpArray[$j]['label'] = 'Changement Base'; //le nom du label dans le gantt
                     $tmpArray[$j]['customClass'] = "ganttChangementBase"; //la couleur du bloc dans le gantt
                     
                     $j++;
                     } */
                    
                    //gestions des stagiaires
                    $stagiaires = $pilote->getStagiaires();
                    $tmpArray = array();
                    
                    $j = 0;
                    foreach ($stagiaires as $stagiaire) {
                        
                        /* Remplissage du tableau tmp des indispos  */
                        $tmpArray[$j]['from'] = $stagiaire->getDateDebut()->format('U000');
                        $tmpArray[$j]['to'] = $stagiaire->getDateFin()->format('U000'); //date de début dans le Gantt
                        //date de fin dans le Gantt
                        $tmpArray[$j]['label'] = 'Stagiaire'; //le nom du label dans le gantt
                        $tmpArray[$j]['customClass'] = "ganttStagiaire"; //la couleur du bloc dans le gantt
                        $j++;
                    }
                    
                    $ndCadres = $pilote->getNominationDenominationCadres();
                    foreach ($ndCadres as $ndCadre) {
                        $fonctionC = $this->getDoctrine()->getRepository('GestionBundle:Fonction')->findOneBy(array('id_fonction' => $ndCadre->getNouvelleFonction()));
                        $tmpArray[$j]['from'] = $ndCadre->getDateNomination()->format('U000'); //date de début dans le Gantt
                        $tmpArray[$j]['to'] = $ndCadre->getDateDenomination()->format('U000'); //date de fin dans le Gantt
                        if ($fonctionC != null){
                            $tmpArray[$j]['label'] = $fonctionC->getTypeFonction(); //le nom du label dans le gantt
                        }else{
                            $tmpArray[$j]['label'] = "Cadre"; //le nom du label dans le gantt
                        }
                        $tmpArray[$j]['customClass'] = "ganttCadre"; //la couleur du bloc dans le gantt
                        
                        $j++;
                    }
                    $ndInstructeurs = $pilote->getNominationDenominationInstructeurs();
                    
                    foreach ($ndInstructeurs as $ndInstructeur) {
                        $fonctionI = $this->getDoctrine()->getRepository('GestionBundle:Fonction')->findOneBy(array('id_fonction' => $ndInstructeur->getNouvelleFonction()));
                        $tmpArray[$j]['from'] = $ndInstructeur->getDateNomination()->format('U000'); //date de début dans le Gantt
                        $tmpArray[$j]['to'] = $ndInstructeur->getDateFinTheo()->format('U000'); //date de fin dans le Gantt
                        if ($fonctionI != null){
                            $tmpArray[$j]['label'] = $fonctionI->getTypeFonction(); //le nom du label dans le gantt
                        }else{
                            $tmpArray[$j]['label'] = "Instructeur"; //le nom du label dans le gantt
                        }
                        $tmpArray[$j]['label'] = $fonctionI->getTypeFonction(); //le nom du label dans le gantt
                        $tmpArray[$j]['customClass'] = "ganttInstructeur"; //la couleur du bloc dans le gantt
                        
                        $j++;
                    }
                    $prets = $pilote->getPretInterSecteurs();
                    foreach ($prets as $pret) {
                        
                        $tmpArray[$j]['from'] = $pret->getDateDebutPret()->format('U000'); //date de début dans le Gantt
                        $tmpArray[$j]['to'] = $pret->getDateFinPret()->format('U000'); //date de fin dans le Gantt
                        $tmpArray[$j]['label'] = 'Pret inter flotte'; //le nom du label dans le gantt
                        $tmpArray[$j]['customClass'] = "ganttPretInter"; //la couleur du bloc dans le gantt
                        
                        $j++;
                    }
                    
                   
                    $arrayJson[$i]['values'] = $tmpArray;
                    
                    $i++;
                }
            }
            return new Response(json_encode($arrayJson));
        }
    }
    
    
} // fin classe

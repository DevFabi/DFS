<?php
namespace GestionBundle\Service;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;



 class SearchEvent
{
     
    private $router;
    private $session;
   
    public function __construct(\Symfony\Bundle\FrameworkBundle\Routing\Router $router, \Symfony\Component\HttpFoundation\Session\SessionInterface $session)
    {
        $this->router = $router;
        $this->session = $session;
    }
    
    // Permet de rechercher si un evenement est en cours a la date du debut d'un nouveau d'evenement
    public function doubleEvent($pilote, $startDate){
        
        /* VERIFICATION : Si un evenement a lieu en meme temps */
        /* On recupere tous les evenements du pilote */
        $indispos = $pilote->getIndisponibles();
        $ndCadres = $pilote->getNominationDenominationCadres();
        $ndInstructeurs = $pilote->getNominationDenominationInstructeurs();
        $Prets = $pilote->getPretInterSecteurs();
        
        /* Pour chaque evenement d'indisponibilite */
        foreach ($indispos as $indispo) {
            /* Je recupere la date de debut et de fin */
            $d1 = $indispo->getDateDebut();
            $d2 = $indispo->getDateFin();
            /* Si ma date de debut de creation d'evenement se trouve dans un evenement en cours */
            if ($startDate > $d1 && $startDate < $d2) {
                /* Je n'enregistre rien dans la bdd et j'affiche un message d'erreur */
                $this->session->getFlashBag()->add('warning', 'Vous avez un evenement Indisponible en meme temps, cloturez le');
                return new RedirectResponse($this->router->generate('effectifs'));
               
            }
        }
        /* Pour chaque evenement cadre */
        foreach ($ndCadres as $ndCadre) {
            $d1 = $ndCadre->getDateNomination();
            $d2 = $ndCadre->getDateDenomination();
            if ($startDate > $d1 && $startDate < $d2) {
                $this->session->getFlashBag()->add('warning', 'Vous avez un evenement Cadre en meme temps, cloturez le');
                return new RedirectResponse($this->router->generate('effectifs'));
            }
        }
        /* Pour chaque evenement instructeur */
        foreach ($ndInstructeurs as $ndInstructeur) {
            $d1 = $ndInstructeur->getDateNomination();
            $d2 = $ndInstructeur->getDateFinTheo();
            if ($startDate > $d1 && $startDate < $d2) {
                $this->session->getFlashBag()->add('warning', 'Vous avez un evenement Instructeur en meme temps, cloturez le');
                return new RedirectResponse($this->router->generate('effectifs'));
            }
        }
        /* Pour chaque evenement pret */
        foreach ($Prets as $pret) {
            $d1 = $pret->getDateDebutPret();
            $d2 = $pret->getDateFinPret();
            if ($startDate > $d1 && $startDate < $d2) {
                $this->session->getFlashBag()->add('warning', 'Vous avez un evenement Pret en meme temps, cloturez le');
                return new RedirectResponse($this->router->generate('effectifs'));
            }
        }
        
        return false;
        
    }
    
}


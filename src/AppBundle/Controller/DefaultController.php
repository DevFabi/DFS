<?php

namespace AppBundle\Controller;

use GestionBundle\Entity\Pilote;
use GestionBundle\Form\PiloteType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    
    public function indexAction(Request $request)
    {
        
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')).DIRECTORY_SEPARATOR,
        ]);
    }

        /* Ajout des pilotes ( test ) */
        public function newpiloteAction(Request $request)
    {
        
        $pilote = new Pilote();
        $form = $this->createForm(PiloteType::class, $pilote);
            if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
                    $em = $this->getDoctrine()->getManager();
                    $em->persist($pilote);
                    $em->flush(); 
                    return $this->redirectToRoute('newpilote'); 
            }
        return $this->render('newpilote.html.twig', array('form' => $form->createView(), 
    ));

    }

     
}

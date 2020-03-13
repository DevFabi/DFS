<?php

namespace GestionBundle\Repository;

/**
 * NominationDenominationInstructeurRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class NominationDenominationInstructeurRepository extends \Doctrine\ORM\EntityRepository
{
	public function findDateInstructeur($pilote)
    {
        return $this
          ->createQueryBuilder('i')
          ->where("i.pilote = :pilote")
          ->setParameters(array(
                                'pilote'=> $pilote))->getQuery()->getResult();

    }
    /* Recherche si un evenement est en cours a Today */
    public function getEventInstructeur($today, $pilote) {
        
        $parameters = array();
        $parameters['today'] = $today;
        $parameters['idPilote'] = $pilote;
        
        $qb = $this->createQueryBuilder('n');
        $qb->join('n.pilote', 'p');
        $qb->select('n');
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->andX(':idPilote = n.pilote'),
                $qb->expr()->andX(':today <= n.dateNomination', ':today >= n.dateFinTheo')
                
                ));
        
        $qb->setParameters($parameters);
        return $qb->getQuery()->getResult();
    }
    
    // Recherche un evenement avec des dates en parametre
    
    public function getEventInstructeurWithDate($debut, $fin, $pilote) {
        
        $parameters = array();
        $parameters['debut'] = $debut;
        $parameters['fin'] = $fin;
        $parameters['idPilote'] = $pilote;
        
        $qb = $this->createQueryBuilder('n');
        $qb->join('n.pilote', 'p');
        $qb->select('n');
        
        $qb->andWhere(':idPilote = n.pilote');
        $qb->andWhere(
            $qb->expr()->orX(
                $qb->expr()->andX('n.dateNomination <=  :debut', 'n.dateFinTheo > :debut'),
                $qb->expr()->andX('n.dateNomination >= :debut', 'n.dateFinTheo <= :fin'),
                $qb->expr()->andX('n.dateNomination <= :debut', 'n.dateFinTheo <= :fin','n.dateFinTheo > :debut'),
                $qb->expr()->andX('n.dateNomination >= :debut','n.dateFinTheo >= :fin', 'n.dateNomination < :fin'
                    )
                ));
        
        $qb->setParameters($parameters);
        return $qb->getQuery()->getResult();
    }
 
}

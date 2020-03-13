<?php
namespace GestionBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Helper\ProgressBar;

use GestionBundle\Entity\Pilote;

class ImportEventPiloteCommand extends ContainerAwareCommand
{
    
    protected function configure()
    {
        // Name and description for app/console command
        $this
        ->setName('import:csv')
        ->setDescription('Importer des evenements pilote depuis un fichier CSV');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        // Showing when the script is launched
        $now = new \DateTime();
        $output->writeln('<comment>Start : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
        
        // Importing CSV on DB via Doctrine ORM
        $this->import($input, $output);
        
        // Showing when the script is over
        $now = new \DateTime();
        $output->writeln('<comment>End : ' . $now->format('d-m-Y G:i:s') . ' ---</comment>');
    }
    
    protected function import(InputInterface $input, OutputInterface $output)
    {
        // Getting php array of data from CSV
        $data = $this->get($input, $output);
        
        // Getting doctrine manager
        $em = $this->getContainer()->get('doctrine')->getManager();
        // Turning off doctrine default logs queries for saving memory
        $em->getConnection()->getConfiguration()->setSQLLogger(null);
        
        // Define the size of record, the frequency for persisting the data and the current index of records
        $size = count($data);
        $batchSize = 20;
        $i = 1;
        
        // Starting progress
        $progress = new ProgressBar($output, $size);
        $progress->start();
        
        // Processing on each row of data
        foreach($data as $row) {
           
            $pilote = $em->getRepository('GestionBundle:Pilote')
            ->findOneByMatricule($row["Matricule"]);
            
            // If the user doest not exist we create one
            if(!is_object($pilote)){
                $pilote = new Pilote();
                $pilote->setMatricule($row["Matricule"]);
                $pilote->setNom($row["NOM"]);
                $pilote->setPrenom($row["Prenom"]);
             /*    $pilote->setFlotte($row[0]);
                $pilote->setBase($row[1]);
                $pilote->setRole($row[5]);
                $pilote->setFonction($row[6]); */
              //  $pilote->setDateNaissance(intval($row["Dte_naissance"]));
               // $pilote->setDteEntreeAf(intval($row['Dte_entrée_AF']));
            }
            
            // Updating info
          /*   $pilote->setLastName($row['lastname']);
            $pilote->setFirstName($row['firstname']); */
            
            // Do stuff here !
            
            // Persisting the current user
            $em->persist($pilote);
            
            // Each 20 users persisted we flush everything
            if (($i % $batchSize) === 0) {
                
                $em->flush();
                // Detaches all objects from Doctrine for memory save
                $em->clear();
                
                // Advancing for progress display on console
                $progress->advance($batchSize);
                
                $now = new \DateTime();
                $output->writeln(' of pilotes event imported ... | ' . $now->format('d-m-Y G:i:s'));
                
            }
            
            $i++;
            
        }
        
        // Flushing and clear data on queue
        $em->flush();
        $em->clear();
        
        // Ending the progress bar process
        $progress->finish();
    }
    
    protected function get(InputInterface $input, OutputInterface $output)
    {
        // Getting the CSV from filesystem
        $fileName = 'web/uploads/import/users.csv';
        
        // Using service for converting CSV to PHP Array
        $converter = $this->getContainer()->get('gestion_bundle.ConvertCsvToArray');
        $data = $converter->convert($fileName, ';');
        
        return $data;
    }
    
}
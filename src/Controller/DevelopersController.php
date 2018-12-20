<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use App\Entity\Transport;
use Psr\Log\LoggerInterface;
use App\Entity\Delay;

class DevelopersController extends AbstractController
{
    /**
     * @Route("/developers", name="developers")
     */
    public function index()
    {
        $this->denyAccessUnlessGranted('ROLE_DEVELOPER');
        return $this->render('developers/index.html.twig');
    }



    //Fonction de conversion du temps pour la sncf
    protected function timeSncf($t)
    {
        $hours=substr($t,0,2);
      if($hours=="00"){$hours="24";}
      $min=substr($t,0,-2);
      $hours=(intval($hours)*60)+intval($min);
      return $hours;
    }

    /**
     * @Route("/generate_incident", name="generate_incident")
     */
    public function generate_table_transport(ObjectManager $manager,LoggerInterface $logger,Request $request)
    {
        
        $this->denyAccessUnlessGranted('ROLE_DEVELOPER');

        //$connection = $entityManager->getConnection();
        //$platform   = $connection->getDatabasePlatform();
        //$connection->executeUpdate($platform->getTruncateTableSQL('my_table', true /* whether to cascade */));


        $opts = [
            'http' => [
                'method' => "GET",
                'header' => "Authorization: Basic MjM2ZDA0ZmQtZDI1MS00YmI5LTk5ZWItY2U5M2EwOWNmNWQ3Og=="
            ]
        ];

        $opts = stream_context_create($opts);
        $json_file = json_decode(file_get_contents("https://api.sncf.com/v1/coverage/sncf/disruptions//?since=20181220T024314&count=500", false, $opts), true);
        $json_file = $json_file['disruptions'];
        $i=0;
        foreach ($json_file as $disp ) {
            $bool;
            $transport = new Transport();
            $delay = new Delay();
            $i++;//Pour le log
                if(isset($disp['impacted_objects'][0]['impacted_stops']) && isset($disp['impacted_objects'][0]['impacted_stops'][count($disp['impacted_objects'][0]['impacted_stops'])-1]['stop_time_effect']) )
                {
                    $verif=$disp['impacted_objects'][0]['impacted_stops'][count($disp['impacted_objects'][0]['impacted_stops'])-1]['stop_time_effect'];
                    $bool=true;
                }else
                {
                    $verif="delayed";
                    $bool=false;

                }
            

            if($verif=="delayed")
            {
                $transport->addDelay($delay);
                $transport->setIdUnique($disp['disruption_id']);
                $transport->setTransportType('Train');
                if(isset($disp['messages'][0]['text']))
                {
                    $transport->setCause($disp['messages'][0]['text']);
                }else
                {
                    $transport->setCause('Inconnue');
                }

                if($bool){
                    //Retard
                    $Larr=$disp['impacted_objects'][0]['impacted_stops'][count($disp['impacted_objects'][0]['impacted_stops'])-1]['amended_arrival_time'];
                    $Ldep= $disp['impacted_objects'][0]['impacted_stops'][count($disp['impacted_objects'][0]['impacted_stops'])-1]['base_arrival_time'];
                    $transport->setBrutDelay($Larr." - ".$Ldep);
                    $delay->setDelayTime(($this->timeSncf($Larr) - $this->timeSncf($Ldep)) );
                    //Ligne
                    $transport->setLine($disp['impacted_objects'][0]['impacted_stops'][0]['stop_point']['name']."/".$disp['impacted_objects'][0]['impacted_stops'][count($disp['impacted_objects'][0]['impacted_stops'])-1]['stop_point']['name']);
                }else
                {
                    $transport->setBrutDelay("DELETED");
                    $transport->setLine("Trajet supprimé");
                    $delay->setDelayTime('-1');
                }
                $delay->setDelayDay(new \DateTime('now'));
                //Log en cas de probleme : $logger->info($i."- ".$disp['disruption_id']);
                $manager->persist($transport);
                $manager->persist($delay);
            }

        }
        $manager->flush();

        
        
        return $this->redirectToRoute('developers');
    }
}

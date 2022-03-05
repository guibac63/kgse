<?php

namespace App\Controller;

use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MissionDetailController extends AbstractController
{
    #[Route('/mission/{id}', name: 'mission_detail')]
    public function displayMission(int $id, MissionRepository $missions): Response
    {
        //get data of the selected mission
        $missionDetail = $missions->findBy(['id'=>$id]);

        return $this->render('mission_detail/mission.html.twig', [
            'missionDetail' => $missionDetail[0],
        ]);
    }
}

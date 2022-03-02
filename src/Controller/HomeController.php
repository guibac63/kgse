<?php

namespace App\Controller;

use App\Repository\CountryRepository;
use App\Repository\MissionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;


class HomeController extends AbstractController
{

    #[Route(path: '/', name: 'home')]
        function homepage(MissionRepository $missions,CountryRepository $countries):Response
    {
        //collect all the missions datas to display in a twig template list
        $missionData = $missions->findAll();

        return $this->render('home.html.twig', ["missions"=>$missionData]);
    }

}
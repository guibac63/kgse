<?php

namespace App\Controller;

use App\Entity\Mission;
use App\Repository\MissionRepository;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;



class HomeController extends AbstractController
{

    #[Route(path: '/', name: 'home')]
        function homepage(MissionRepository $missions,PaginatorInterface $paginator,Request $request):Response
    {
        //create search form for missions
        $searchMission = ['message' => 'Type your search here'];
        $form = $this->createFormBuilder($searchMission)
            ->add('search',TextType::class)
            ->getForm();

        $form->handleRequest($request);

        //get the search form data to prepare a 'search like request'
        if ($form->isSubmitted() && $form->isValid()) {
            $dataSearch = $form->getData()['search'];
        }else{
            $dataSearch = null;
        }

        // if a search is submit, get the results with a limit of 5
        if($dataSearch){
            $missionData = $missions->findBySearch($dataSearch);
            $isPaginated = false;
        }else{
            //collect all the missions datas to display in a twig template list
            $missionData = $missions->findAll();
            //create pagination with knp paginator with max 5 missions per page
            $isPaginated = true;
            $missionData = $paginator->paginate(
                $missionData,
                $request->query->getInt('page',1),
                5
            );
        };

        return $this->render('home.html.twig', [
            "missions"=>$missionData,
            'form'=>$form->createView(),
            'isPaginated'=>$isPaginated]
        );
    }

}
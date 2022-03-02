<?php

namespace App\Controller\Admin;

use App\Entity\Agent;
use App\Entity\Contact;
use App\Entity\Country;
use App\Entity\HidingPlace;
use App\Entity\Mission;
use App\Entity\Skills;
use App\Entity\Target;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        //return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //


        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(AgentCrudController::class)->generateUrl());

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('KGSE ADMIN')

            // the path defined in this method is passed to the Twig asset() function
            ->setFaviconPath('favicon.svg');
    }

    public function configureMenuItems(): iterable
    {

        //yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToUrl('Homepage','fas fa-home' , $this->generateUrl('home') );
        yield MenuItem::linkToCrud('Agents', 'fas fa-user-secret', Agent::class);
        yield MenuItem::linkToCrud('Missions', 'fas fa-list', Mission::class);
        yield MenuItem::linkToCrud('Skills', 'fas fa-atom', Skills::class);
        yield MenuItem::linkToCrud('Contacts', 'fas fa-address-book', Contact::class);
        yield MenuItem::linkToCrud('Countries', 'fas fa-globe', Country::class);
        yield MenuItem::linkToCrud('Hiding Places', 'fas fa-place-of-worship', HidingPlace::class);
        yield MenuItem::linkToCrud('Targets', 'fas fa-bullseye', Target::class);


    }
}

<?php

namespace App\Controller\Admin;

use App\Entity\Album;
use App\Entity\Artist;
use App\Entity\Genre;
use App\Entity\Song;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    // on va créer un constructeur qui prends comme parametre qui prend comme instance adminurlgenerator 
    public function __construct(private AdminUrlGenerator $adminUrlGenerator){
    }   

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // return parent::index();
        
        //ici on lui donne l'entité que l'on souhaite affiché dans le dashboard 
        $url = $this->adminUrlGenerator->setController(GenreCrudController::class)->generateUrl();
        return $this->redirect($url);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect($adminUrlGenerator->setController(OneOfYourCrudController::class)->generateUrl());

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
            ->setTitle('<img src="/image/logo.png" alt="logo" style="height: 50px ; margin-right:10px;" /> <span class="test-small">Spotify</span>')
            ->setFaviconPath('/image/logo.png');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Gestion discographique');
        //liste des sous menus 
        yield MenuItem::subMenu('Gestion Categories','fa fa-star')->setSubItems([
            MenuItem::linkToCrud('Ajouter une catégorie', 'fa fa-plus', Genre::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les catégories' ,'fa fa-eye',Genre::class),
        ]);

        yield MenuItem::subMenu('Gestion Album','fa-regular fa-hard-drive')->setSubItems([
            MenuItem::linkToCrud('Ajouter un album', 'fa fa-plus', Album::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les albums' ,'fa fa-eye',Album::class),
        ]);
        
        yield MenuItem::subMenu('Gestion Chansons','fa-solid fa-record-vinyl')->setSubItems([
            MenuItem::linkToCrud('Ajouter une chanson', 'fa fa-plus', Song::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les chansons' ,'fa fa-eye',Song::class),
        ]);

        yield MenuItem::subMenu('Gestion Artistes','fa fa-music')->setSubItems([
            MenuItem::linkToCrud('Ajouter un artiste', 'fa fa-plus', Artist::class)->setAction(Crud::PAGE_NEW),
            MenuItem::linkToCrud('Voir les artistes' ,'fa fa-eye',Artist::class),
        ]);



        // yield MenuItem::linkToCrud('The Label', 'fas fa-list', EntityClass::class);
    }
}

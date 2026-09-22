<?php

namespace App\Controller\Admin;

use App\Entity\SupportAct;
use EasyCorp\Bundle\EasyAdminBundle\Attribute\AdminDashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SectionMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\Menu\SubMenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;

#[AdminDashboard(routePath: '/admin', routeName: 'admin')]
class AdminController extends AbstractDashboardController
{
    public function index(): Response
    {
        return $this->render('admin/my-dashboard.html.twig', [

        ]);

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        // return $this->redirectToRoute('admin_user_index');

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirectToRoute('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }


    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Madness Admin')
        ->renderContentMaximized();
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::section('Concerts');
        yield MenuItem::linkTo(LiveEventCrudController::class, 'LiveEvent', 'fas fa-calendar');
        yield MenuItem::linkTo(EventPictureCrudController::class, 'EventPicture', 'fas fa-image');

        yield MenuItem::section('Configuration');
        yield MenuItem::linkTo(EventLocationCrudController::class, 'EventLocation', 'fas fa-location-dot');
        yield MenuItem::linkTo(SupportActCrudController::class, 'SupportAct', 'fas fa-guitar');
        yield MenuItem::linkTo(BandMemberCrudController::class, 'bandMember', 'fas fa-users');
        yield MenuItem::linkTo(MusicCrudController::class, 'music', 'fas fa-music');
        yield MenuItem::linkTo(PageCrudController::class, 'page', 'fas fa-file');

        yield MenuItem::section('User');
        yield MenuItem::linkTo(UserCrudController::class, 'user', 'fas fa-user');
    }
}

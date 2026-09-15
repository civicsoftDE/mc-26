<?php

namespace App\Controller;

use App\Repository\LiveEventRepository;
use App\Repository\PageRepository;
use App\Service\MastodonService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/', name: 'app_')]
final class AppController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('', name: 'index')]
    public function index(MastodonService $mastodon, LiveEventRepository $eventRepository): Response
    {
        $concerts = $eventRepository->findUpcomingConcerts(1);
        $posts = $mastodon->getAccountPosts('@madnesscrunch@mastodon.social', 4);

        return $this->render('app/index.html.twig', [
            'posts' => $posts,
            'controller_name' => 'AppController',
            'concerts' => $concerts,
        ]);
    }

    #[Route('rechtliches', name: 'page_index')]
    public function legalIndex(PageRepository $repository): Response
    {
        $pages = $repository->findAll();

        return $this->render('app/legal.html.twig', [
            'items' => $pages,
        ]);
    }

    #[Route('rechtliches/{slug}', name: 'page_show')]
    public function legal(string $slug, PageRepository $repository): Response
    {
        $page = $repository->findOneBy(['slug' => $slug]);
        if (!$page) {
            return $this->redirectToRoute('app_index');
        }
        return $this->render('app/page.html.twig', [
            'page' => $page,
        ]);
    }
}

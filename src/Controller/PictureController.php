<?php

namespace App\Controller;

use App\Repository\EventPictureRepository;
use App\Repository\LiveEventRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/picture', name: 'picture_')]
final class PictureController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(LiveEventRepository $repository): Response
    {
        $events = $repository->findPastConcerts();

        return $this->render('picture/index.html.twig', [
            'events' => $events,
        ]);
    }
}

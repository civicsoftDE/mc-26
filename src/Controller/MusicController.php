<?php

namespace App\Controller;

use App\Repository\MusicRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/music', name: 'music_')]
final class MusicController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(MusicRepository $repository): Response
    {
        $songs = $repository->findBy(['isPublished' => true]);
        return $this->render('music/index.html.twig', [
            'songs' => $songs,
        ]);
    }
}

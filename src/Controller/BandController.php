<?php

namespace App\Controller;

use App\Repository\BandMemberRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/band', name: 'band_')]
final class BandController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(BandMemberRepository $memberRepository): Response
    {
        $members = $memberRepository->findAll();
        return $this->render('band/index.html.twig', [
            'controller_name' => 'BandController',
            'members' => $members,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(String $slug, BandMemberRepository $memberRepository): Response
    {
        $member = $memberRepository->findOneBy(['slug' => $slug]);
        $prev = $memberRepository->findPrevMember($member->getId());
        $next = $memberRepository->findNextMember($member->getId());

        if (!$member) {
            $this->addFlash('danger', 'Das Bandmitglied ist nicht vorhanden');
            return $this->redirectToRoute('band_index');
        }
        return $this->render('band/show.html.twig', [
            'controller_name' => 'BandController',
            'member' => $member,
            'prev' => $prev,
            'next' => $next,
        ]);
    }
}

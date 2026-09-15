<?php

namespace App\Controller;

use App\Entity\LiveEvent;
use App\Entity\LiveEventComment;
use App\Entity\User;
use App\Form\LiveEventCommentType;
use App\Repository\LiveEventRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/concert', name: 'concert_')]
final class ConcertController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(LiveEventRepository $eventRepository): Response
    {
        $concerts = $eventRepository->findUpcomingConcerts();
        $oldConcerts = $eventRepository->findPastConcerts();
        return $this->render('concert/index.html.twig', [
            'controller_name' => 'ConcertController',
            'concerts' => $concerts,
            'old_concerts' => $oldConcerts,
        ]);
    }

    #[Route('/{slug}', name: 'show')]
    public function show(String $slug, LiveEventRepository $eventRepository, Request $request): Response
    {
        $liveEvent = $eventRepository->findOneBy(['slug' => $slug]);
        if (!$liveEvent) {
            $this->addFlash('danger', 'LiveEvent not found');
            return $this->redirectToRoute('concert_index');
        }
        $comment = new LiveEventComment();
        $comment->setLiveEvent($liveEvent);
        $form = $this->createForm(LiveEventCommentType::class, $comment);

        $concerts = $eventRepository->findUpcomingConcerts();
        $oldConcerts = $eventRepository->findPastConcerts();

        return $this->render('concert/show.html.twig', [
            'current_live_event' => $liveEvent,
            'concerts' => $concerts,
            'old_concerts' => $oldConcerts,
            'commentForm' => $form->createView(),
        ]);
    }

    #[Route('/{id}/comment', name: 'place_comment', methods: ['POST'])]
    public function placeComment(LiveEvent $concert, Request $request, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $comment = new LiveEventComment();
        $comment->setLiveEvent($concert);
        $comment->setUser($this->getUser());
        $form = $this->createForm(LiveEventCommentType::class, $comment);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($comment);
            $em->flush();
            return $this->render('concert/_comment_item.html.twig', [
                'comment' => $comment,
            ]);
        }
        return new Response('Fehler beim Speichern', 400);
    }

    #[Route('/{id}/comment/remove', name: 'remove_comment', methods: ['POST'])]
    public function removeComment(LiveEventComment $comment, EntityManagerInterface $em): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $em->remove($comment);
        $em->flush();

        return $this->redirectToRoute('concert_refresh_comments', [
            'id' => $comment->getLiveEvent()->getId()
        ]);
    }

    #[Route('/{id}/comment/refresh', name: 'refresh_comments')]
    public function refreshComments(LiveEvent $concert): Response
    {
        $comments = $concert->getLiveEventComments();

        return $this->render('concert/_comment_list.html.twig', [
            'comments' => $comments,
        ]);
    }
}

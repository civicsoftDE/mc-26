<?php

namespace App\Controller;


use App\Entity\EventPicture;
use App\Form\EventImageType;
use App\Repository\EventPictureRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Csrf\CsrfToken;
use Symfony\Component\Security\Csrf\CsrfTokenManagerInterface;

#[Route('/profile', name: 'profile_')]
final class ProfileController extends AbstractController
{
    #[Route('', name: 'index')]
    public function index(EventPictureRepository $pictureRepository): Response
    {
        $pictures = $pictureRepository->findBy(['publishedBy' => $this->getUser()]);
        $form = $this->createForm(EventImageType::class, new EventPicture());
        return $this->render('profile/index.html.twig', [
            'upload_form' => $form->createView(),
            'pictures' => $pictures,
        ]);
    }

    #[Route('/upload/image', name: 'upload_image')]
    public function addImage(Request $request, EntityManagerInterface $entityManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $picture = new EventPicture();
        $picture->setPublishedBy($this->getUser());
        if ($this->isGranted('ROLE_ADMIN')) {
            $picture->setIsPublished(true);
        } else {
            $picture->setIsPublished(false);
        }

        $form = $this->createForm(EventImageType::class, $picture);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($picture);
            $entityManager->flush();
            $this->addFlash("success", "Bild wurde erfolgreich hochgeladen.");
        } else {
            $this->addFlash("danger", "Fehler beim Hochladen des Bildes ist aufgetreten.");
        }
        return $this->redirectToRoute('profile_index');
    }

    #[Route('/delete/image/{id}', name: 'delete_image', methods: ['POST'])]
    public function deleteImage(Request $request, EventPicture $eventPicture, EntityManagerInterface $entityManager,
    CsrfTokenManagerInterface $csrfTokenManager): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');

        $token = new CsrfToken('delete-image-' . $eventPicture->getId(), $request->request->get('_token'));
        if (!$csrfTokenManager->isTokenValid($token)) {
            $this->addFlash("danger", "Ungültige Anfrage.");
            return $this->redirectToRoute('profile_index');
        }

        if ($eventPicture->getPublishedBy() !== $this->getUser()) {
            $this->addFlash("danger", "Dieses Bild existiert nicht.");
            return $this->redirectToRoute('profile_index');
        }

        $entityManager->remove($eventPicture);
        $entityManager->flush();
        $this->addFlash("success", "Bild wurde erfolgreich entfernt.");

        return $this->redirectToRoute('profile_index');
    }
}

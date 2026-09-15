<?php

namespace App\Controller;

use App\Service\MastodonService;
use Psr\Cache\InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/blog', name: 'blog_')]
final class BlogController extends AbstractController
{
    /**
     * @throws InvalidArgumentException
     */
    #[Route('', name: 'index')]
    public function index(MastodonService $mastodon): Response
    {
        $posts = $mastodon->getAccountPosts('@madnesscrunch@mastodon.social', 12);
        return $this->render('blog/index.html.twig', [
            'posts' => $posts,
        ]);
    }
}

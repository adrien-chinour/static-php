<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/article/{slug}.html', name: 'article', requirements: ['slug' => '^[a-zA-Z0-9\-]+$'], methods: ['GET'])]
class ArticleController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repository
    ) {}

    public function __invoke(Request $request, string $slug): Response
    {
        if (null === ($article = $this->repository->find($slug))) {
            return new Response(null, 404);
        }

        $content = $this->renderView('article.html.twig', [
            'article' => $article,
        ]);

        return new Response($content, 200);
    }
}

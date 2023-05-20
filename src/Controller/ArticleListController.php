<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Repository\ArticleRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/articles.html', name: 'articles', methods: ['GET'])]
class ArticleListController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository $repository
    ) {}

    public function __invoke(): Response
    {
        $content = $this->renderView('article-list.html.twig', [
            'articles' => $this->repository->findAll(),
        ]);

        return new Response($content, 200);
    }
}

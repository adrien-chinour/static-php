<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Repository\ArticleRepository;
use App\Content\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/index.html', name: 'home', methods: ['GET'])]
class HomeController extends AbstractController
{
    public function __construct(
        private readonly ArticleRepository         $articleRepository,
        private readonly ProjectRepository $projectRepository
    ) {}

    public function __invoke(): Response
    {
        $content = $this->renderView('home.html.twig', [
            'articles' => $this->articleRepository->findAll(),
            'projects' => $this->projectRepository->findAll(),
        ]);

        return new Response($content, 200);
    }
}

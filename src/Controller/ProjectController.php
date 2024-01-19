<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projet/{slug}.html', name: 'project', requirements: ['slug' => '^[a-zA-Z0-9\-]+$'], methods: ['GET'])]
FINAL class ProjectController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $repository
    ) {}

    public function __invoke(string $slug): Response
    {
        if (null === ($project = $this->repository->find($slug))) {
            return new Response(null, 404);
        }

        $content = $this->renderView('project.html.twig', [
            'project' => $project,
        ]);

        return new Response($content, 200);
    }
}

<?php

declare(strict_types=1);

namespace App\Controller;

use App\Content\Repository\ProjectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/projets.html', name: 'projects', methods: ['GET'])]
class ProjectListController extends AbstractController
{
    public function __construct(
        private readonly ProjectRepository $repository
    ) {}

    public function __invoke(): Response
    {
        $content = $this->renderView('project-list.html.twig', [
            'projects' => $this->repository->findAll(),
        ]);

        return new Response($content, 200);
    }

}

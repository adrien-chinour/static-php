<?php

declare(strict_types=1);

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/a-propos.html', name: 'about', methods: ['GET'])]
final class AboutController extends AbstractController
{
    public function __invoke(): Response
    {
        $content = $this->renderView('about.html.twig');

        return new Response($content, 200);
    }
}

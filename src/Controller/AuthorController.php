<?php

namespace App\Controller;

use App\Service\AuthorService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class AuthorController extends AbstractController
{
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    #[Route('/authors/top3', methods: ['GET'])]
    public function showTop3Authors(): JsonResponse{
        $top3Authors = $this->authorService->getTop3AuthorsWithMostArticlesLastWeek();
        return new JsonResponse($top3Authors);
    }

    #[Route('/create-default-authors', methods: ['POST'])]
    public function createDefaultAuthors(): Response{
        $this->authorService->createDefaultAuthors();
        return new Response('You create 3 default authors!');
    }
}
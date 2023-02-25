<?php

namespace App\Controller;

use App\Service\AuthorService;
use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class MainController extends AbstractController
{
    private $articleService;
    private $authorService;

    public function __construct(ArticleService $articleService, AuthorService $authorService)
    {
        $this->articleService = $articleService;
        $this->authorService = $authorService;
    }

    #[Route('/articles/{id}', name: 'show_article')]
    public function showArticleById(int $id): Response{
        $article = $this->articleService->getArticleById($id);
        return new Response('Your Article');
        dump($article);
    }

    #[Route('/create-default-authors')]
    public function createDefaultAuthors(): Response{
        $this->authorService->createDefaultAuthors();
        return new Response('You create 3 default authors!');
    }
}
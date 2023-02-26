<?php

namespace App\Controller;

use App\Service\ArticleService;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ArticleController extends AbstractController
{
    private $articleService;
    
    public function __construct(ArticleService $articleService)
    {
        $this->articleService = $articleService;
    }

    #[Route('/articles/{id}', methods: ['GET'])]
    public function getArticleById(int $id): JsonResponse{
        $data = $this->articleService->getArticleById($id);
        if(array_key_exists('notFoundError', $data)){
            return new JsonResponse($data, Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($data);
    }

    #[Route('/author/{authorId}/articles', methods: ['GET'])]
    public function getArticlesForGivenAuthor(int $authorId): Response{
        $data = $this->articleService->getArticlesForGivenAuthor($authorId);
        if(array_key_exists('notFoundError', $data)){
            return new JsonResponse($data, Response::HTTP_NOT_FOUND);
        }
        return new JsonResponse($data);
    }
}
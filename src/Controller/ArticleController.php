<?php

namespace App\Controller;

use DateTimeImmutable;
use App\Entity\Article;
use App\Form\ArticleType;
use App\Service\ArticleService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
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

    #[Route('/articles/create')]
    public function createArticle(EntityManagerInterface $em, Request $request): Response{
        $article = new Article();
        $article->setCreatedAt(new DateTimeImmutable());
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $article = $form->getData();

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'Created New Article!');
        }

        return $this->render('add_edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/articles/edit/{id}')]
    public function editArticle(int $id, EntityManagerInterface $em, Request $request): Response{
        $article = $em->getRepository(Article::class)->find($id);
        $form = $this->createForm(ArticleType::class, $article);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {

            $em->persist($article);
            $em->flush();

            $this->addFlash('success', 'You Edited Article!');
        }

        return $this->render('add_edit_article.html.twig', [
            'form' => $form->createView(),
        ]);
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
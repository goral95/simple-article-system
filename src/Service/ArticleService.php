<?php 
namespace App\Service;

use App\Entity\Article;
use Doctrine\ORM\EntityManagerInterface;

class ArticleService
{
    private $entityManager;
    private $articleRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->articleRepository = $entityManager->getRepository(Article::class);
    }

    public function getArticleById(int $id): Article
    {
        return $this->articleRepository->find($id);
    }

}
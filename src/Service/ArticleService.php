<?php 
namespace App\Service;

use App\Entity\Article;
use App\Entity\Author;
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

    public function getArticleById(int $id): array
    {
        $article = $this->articleRepository->find($id);
        if(empty($article)){
            return array('notFoundError' => 'Not found article by id: '.$id);
        }
        return $this->convertArticleToJson($article);
    }

    public function getArticlesForGivenAuthor(int $authorId): array
    {
        $author = $this->entityManager->getRepository(Author::class)->find($authorId);
        if(empty($author)){
            return array('notFoundError' => 'Not found author by id: '.$authorId);
        }
        $articles = $author->getArticles()->toArray();
        $articlesJson = [];
        foreach($articles as $article){
            array_push($articlesJson, $this->convertArticleToJson($article)) ;
        }

        return $articlesJson;
    }

    private function convertArticleToJson(Article $article): array
    {
        $articleJson = [];
        $dataAuthors = [];

        foreach($article->getAuthors()->toArray() as $author){
            $dataAuthors[] = [
                'authorId' => $author->getId(),
                'name' => $author->getName()
            ];
        }
        
        $articleJson[] = [
            'id' => $article->getId(),
            'title' => $article->getTitle(),
            'text' => $article->getText(),
            'authors' => $dataAuthors
        ];

        return $articleJson;
    }

}
<?php 
namespace App\Service;

use App\Entity\Author;
use Doctrine\ORM\EntityManagerInterface;

class AuthorService
{
    private $entityManager;
    private $authorRepository;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
        $this->authorRepository = $entityManager->getRepository(Author::class);
    }

    public function getTop3AuthorsWithMostArticlesLastWeek(): ?array
    {
        return $this->authorRepository->find3AuthorsWithMostArticlesLastWeek(date("Y-m-d H:i:s", strtotime('-7 day')));
    }

    public function createDefaultAuthors(): void
    {
        $author1 = new Author();
        $author1->setName('Author X');
        $this->entityManager->persist($author1);

        $author2 = new Author();
        $author2->setName('Author Y');
        $this->entityManager->persist($author2);

        $author3 = new Author();
        $author3->setName('Author Z');
        $this->entityManager->persist($author3);

        $this->entityManager->flush();
    }

    
}
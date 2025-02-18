<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Factory\Entity\AuthorFactory;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;

readonly class MutationService
{
    public function __construct(private EntityManagerInterface $entityManager, private AuthorFactory $authorFactory)
    {
    }

    public function createAuthor(array $authorDetails): Author
    {
        $author = $this->authorFactory->create(
            $authorDetails['name'],
            DateTime::createFromFormat('d/m/Y', $authorDetails['dateOfBirth']),
            $authorDetails['bio']
        );

        $this->entityManager->persist($author);
        $this->entityManager->flush();

        return $author;
    }

    public function updateBook(int $bookId, array $bookDetails): Book
    {
        $book = $this->entityManager->getRepository(Book::class)->find($bookId);

        if (is_null($book)) {
            throw new \Error("Book not found");
        }
        foreach ($bookDetails as $property => $value) {
            $book->$property = $value;
        }

        $this->entityManager->persist($book);
        $this->entityManager->flush();

        return $book;
    }
}

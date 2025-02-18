<?php

namespace App\Service;

use App\Entity\Author;
use App\Entity\Book;
use App\Repository\AuthorRepository;
use App\Repository\BookRepository;
use Doctrine\Common\Collections\Collection;


class QueryService
{

    public function __construct(
        private readonly AuthorRepository $authorRepository,
        private readonly BookRepository $bookRepository
    )
    {}

    public function findAuthorById(int $authorId): ?Author
    {
        return $this->authorRepository->find($authorId);
    }

    public function getAllAuthors(): array
    {
        return $this->authorRepository->findAll();
    }

    public function findBooksByAuthorName(string $authorName): Collection
    {
        return $this->authorRepository->findOneBy(['name' => $authorName])
            ->getBooks();
    }

    public function findAllBooks(): array
    {
        return $this->bookRepository->findAll();
    }

    public function findBooksByGenre(string $genre): Collection
    {
        return $this->bookRepository->findBy(['genre' => $genre]);
    }

    public function findBookById(int $bookId): ?Book
    {
        return $this->bookRepository->find($bookId);
    }
}
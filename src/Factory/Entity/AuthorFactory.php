<?php

namespace App\Entity\Factory;

use App\Entity\Author;
use DateTimeInterface;

class AuthorFactory
{
    public static function create(string $name, DateTimeInterface $dateOfBirth, string $bio): Author
    {
        return new Author($name, $dateOfBirth, $bio);
    }
}
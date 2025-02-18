<?php

declare(strict_types=1);

namespace App\Factory\Entity;

use App\Entity\Author;
use DateTimeInterface;

class AuthorFactory
{
    public static function create(string $name, DateTimeInterface $dateOfBirth, string $bio): Author
    {
        return new Author($name, $dateOfBirth, $bio);
    }
}

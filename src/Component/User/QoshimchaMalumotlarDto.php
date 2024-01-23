<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Annotation\Groups;

class QoshimchaMalumotlarDto
{
    public function __construct(
        #[Groups(['user:write', 'user:read'])]
        private string $categoryName,

        #[Groups(['user:write', 'user:read'])]
        private string $bookName,

        #[Groups(['user:write', 'user:read'])]
        private string $description,

        #[Groups(['user:write', 'user:read'])]
        private string $givenName,

        #[Groups(['user:write', 'user:read'])]
        private int $price
    )
    {

    }

    public function getCategoryName(): string
    {
        return $this->categoryName;
    }

    public function getBookName(): string
    {
        return $this->bookName;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getGivenName(): string
    {
        return $this->givenName;
    }

    public function getPrice(): int
    {
        return $this->price;
    }
}
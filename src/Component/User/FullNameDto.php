<?php

declare(strict_types=1);

namespace App\Component\User;

use Symfony\Component\Serializer\Attribute\Groups;

class FullNameDto
{

    public function __construct(
        #[Groups(['user:write', 'user:read'])]
        private string $giveName,

        #[Groups(['user:write'])]
        private string $familyName,

        #[Groups(['user:write', 'user:read'])]
        private bool $isMarried
    ) {
    }

    public function getGiveName(): string
    {
        return $this->giveName;
    }

    public function getFamilyName(): string
    {
        return $this->familyName;
    }

    public function isMarried(): bool
    {
        return $this->isMarried;
    }
}
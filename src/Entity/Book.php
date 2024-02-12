<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use App\Controller\GetBooksByCategoryAction;
use App\Controller\GetBooksHardExampleAction;
use App\Repository\BookRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: BookRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            uriTemplate: 'book/by-category',
            controller: GetBooksByCategoryAction::class,
            openapiContext: [
                'parameters' => [
                    [
                        'in' => 'query',
                        'name' => 'categoryId',
                        'schema' => [
                            'type' => 'integer'
                        ]
                    ]
                ]
            ],
            name: 'getBooks'
        ),
        new GetCollection(
            uriTemplate: 'book/hard-example',
            controller: GetBooksHardExampleAction::class,
            name: 'booksHardExample'
        ),
        new GetCollection(),
        new Post(),
        new Put(),
        new Get(),
        new Delete()
    ],
    normalizationContext: ['groups' => ['book:read']],
    denormalizationContext: ['groups' => ['book:write']],
)]
#[Groups(['book:read'])]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Groups(['book:write'])]
    private ?string $name = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['book:write'])]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    #[Groups(['book:write'])]
    private ?string $text = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:write'])]
    private ?Category $cetegory = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['book:write'])]
    private ?MediaObject $image = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }

    public function getCetegory(): ?Category
    {
        return $this->cetegory;
    }

    public function setCetegory(?Category $cetegory): static
    {
        $this->cetegory = $cetegory;

        return $this;
    }

    public function getImage(): ?MediaObject
    {
        return $this->image;
    }

    public function setImage(MediaObject $image): static
    {
        $this->image = $image;

        return $this;
    }
}

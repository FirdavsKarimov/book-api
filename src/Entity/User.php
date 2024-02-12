<?php

namespace App\Entity;

use ApiPlatform\Doctrine\Orm\Filter\DateFilter;
use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use App\Component\User\FullNameDto;
use App\Component\User\QoshimchaMalumotlarDto;
use App\Controller\AboutMeAction;
use App\Controller\UserCreateAction;
use App\Controller\UserFullNameAction;
use App\Controller\UserQoshimchaMalumotlarAction;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    operations: [
        new GetCollection(
            security: "is_granted('ROLE_ADMIN')"
        ),
        new GetCollection(
            uriTemplate: 'users/about_me',
            controller: AboutMeAction::class,
            name: 'aboutMe'
        ),
        new Get(
            security: "is_granted('Role_Admin') || object == user"
        ),
        new Get(),
        new Delete(),
        new Post(
            uriTemplate: 'users/my',
            controller: UserCreateAction::class,
            name: 'createUser'
        ),
        new Post(
            uriTemplate: 'users/full-name',
            controller: UserFullNameAction::class,
            input: FullNameDto::class,
            name: 'fullName'
        ),
        new Post(
            uriTemplate: 'users/qoshimcha-malumotlar',
            controller: UserQoshimchaMalumotlarAction::class,
            input: QoshimchaMalumotlarDto::class,
            name: 'qoshimchaMalumotlar'
        ),
        new Post(
            uriTemplate: 'users/auth',
            name: 'auth'
        )
    ],
    normalizationContext: ['groups' => ['user:read']],
    denormalizationContext: ['groups' => ['user:write']],
    paginationItemsPerPage: 10
)]
#[UniqueEntity('email', message: "Bu {{value}} email bazada mavjud!")]
#[ApiFilter(SearchFilter::class, properties: [
    'id' => 'exact',
    'email' => 'partial',
    'phone' => 'start'
])]
#[ApiFilter(OrderFilter::class, properties: ['id'])]
#[ApiFilter(DateFilter::class, properties: ['createdAt'])]
class User implements PasswordAuthenticatedUserInterface, UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email]
    #[Assert\NotBlank(message: "Email bosh bolishi mumkin emas!")]
    #[Groups(['user:read', 'user:write'])]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: "Parolni to'g'ri tering!")]
    #[Groups(['user:write'])]
    private ?string $password = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Range(min: 18, max: 45)]
    #[Groups(['user:read', 'user:write'])]
    private ?int $age = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank]
    #[Assert\Choice(choices: ['man', 'woman'], message: "Bunday jins yo'q")]
    #[Groups(['user:read', 'user:write'])]
    private ?string $gender = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Regex(pattern: '/\D/', message: "Faqat raqam qabul qilinadi", match: false)]
    #[Assert\Length(min: 9, max: 15)]
    #[Groups(['user:read', 'user:write'])]
    private ?string $phone = null;

    #[ORM\Column]
    #[Groups(['user:read'])]
    private array $roles = ["ROLE_USER"];

    #[ORM\Column]
    #[Groups(['user:read'])]
    private ?\DateTimeImmutable $createdAt = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function setAge(?int $age): static
    {
        $this->age = $age;

        return $this;
    }

    public function getGender(): ?string
    {
        return $this->gender;
    }

    public function setGender(string $gender): static
    {
        $this->gender = $gender;

        return $this;
    }

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function eraseCredentials():void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->getEmail();
    }
}

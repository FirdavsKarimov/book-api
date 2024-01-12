<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\UserRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' =>['user:read']],
    denormalizationContext: ['groups' =>['user:write']]
)]
#[UniqueEntity('email', message: "Bu {{value}} email bazada mavjud!")]
class User
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
    private ?string $pasword = null;

    #[ORM\Column(type: Types::SMALLINT, nullable: true)]
    #[Assert\NotBlank]
    #[Assert\Range(min:18, max:45)]
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
    #[Groups(['user:read', 'user:write'])]
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

    public function getPasword(): ?string
    {
        return $this->pasword;
    }

    public function setPasword(string $pasword): static
    {
        $this->pasword = $pasword;

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
}

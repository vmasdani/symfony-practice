<?php

namespace App\Entity;

use App\Repository\EmployeeRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: EmployeeRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Employee
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $termination_date = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $created = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $updated = null;

    #[ORM\Column(type: Types::BIGINT, nullable: true)]
    private ?string $auth_user_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getTerminationDate(): ?\DateTimeInterface
    {
        return $this->termination_date;
    }

    public function setTerminationDate(?\DateTimeInterface $termination_date): self
    {
        $this->termination_date = $termination_date;

        return $this;
    }


    #[ORM\PrePersist]
    public function prePer()
    {
        $this->created = new \DateTime("now");
        $this->updated = new \DateTime("now");
    }

    #[ORM\PreUpdate]
    public function preUp()
    {
        $this->updated = new \DateTime("now");
    }

    public function getCreated(): ?\DateTimeInterface
    {
        return $this->created;
    }

    public function setCreated(?\DateTimeInterface $created): self
    {
        $this->created = $created;

        return $this;
    }

    public function getUpdated(): ?\DateTimeInterface
    {
        return $this->updated;
    }

    public function setUpdated(?\DateTimeInterface $updated): self
    {
        $this->updated = $updated;

        return $this;
    }

    public function getAuthUserId(): ?string
    {
        return $this->auth_user_id;
    }

    public function setAuthUserId(?string $auth_user_id): self
    {
        $this->auth_user_id = $auth_user_id;

        return $this;
    }
}

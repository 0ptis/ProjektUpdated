<?php

/*
 * Entity Lista
 */

namespace App\Entity;

use App\Repository\ListaRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * Entity representing a Lista.
 *
 * This class is used to manage the data associated with a Lista entity.
 * It includes properties for id, title, createdAt, and updatedAt fields,
 * along with their respective getters and setters.
 */
#[ORM\Entity(repositoryClass: ListaRepository::class)]
class Lista
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    private ?string $title = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    /**
     * Setter for Id.
     *
     * @return void
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     *Getter for Title.
     *
     * @return void
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     *Setter for Title.
     *
     * @param string $title title
     *
     * @return void
     */
    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     *Getter for CreatedAt.
     *
     * @return void
     */
    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    /**
     * Setter for CreatedAt.
     *
     * @param \DateTimeImmutable $createdAt Created at
     *
     * @return void
     */
    public function setCreatedAt(\DateTimeImmutable $createdAt): static
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     *Getter for updatedAt.
     *
     * @return void
     */
    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    /**
     * Setter for updatedAt.
     *
     * @param \DateTimeImmutable $updatedAt Updated at
     *
     * @return void
     */
    public function setUpdatedAt(\DateTimeImmutable $updatedAt): static
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}

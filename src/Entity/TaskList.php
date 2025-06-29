<?php

/*
 * Entity TaskList
 */

namespace App\Entity;

use App\Repository\TaskListRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Entity representing a TaskList.
 *
 * This class is used to manage the data associated with a TaskList entity.
 * It includes properties for id, title, createdAt, and updatedAt fields,
 * along with their respective getters and setters.
 */
#[ORM\Entity(repositoryClass: TaskListRepository::class)]
class TaskList
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 64)]
    #[Assert\NotBlank]
    #[Assert\Type('string')]
    #[Assert\Length(min: 3, max: 64)]
    private ?string $title = null;

    #[ORM\Column]
    #[Assert\Type(\DateTimeImmutable::class)]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    #[Assert\Type(\DateTimeImmutable::class)]
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

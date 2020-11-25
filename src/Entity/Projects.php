<?php

namespace App\Entity;

use App\Repository\ProjectsRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProjectsRepository::class)
 */
class Projects
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $page_path;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\File(
     *     maxSize = "1024k",
     *     mimeTypes = {"image/jpeg"},
     *     mimeTypesMessage = "Proszę załaduj plik w formacje JPEG"
     * )
     */
    private $photo_path;

    /**
     * @ORM\Column(type="boolean")
     */
    private $is_public;

    /**
     * @ORM\Column(type="datetime")
     */
    private $modificated_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $uploaded_at;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPagePath(): ?string
    {
        return $this->page_path;
    }

    public function setPagePath(string $page_path): self
    {
        $this->page_path = $page_path;

        return $this;
    }

    public function getIsPublic(): ?bool
    {
        return $this->is_public;
    }

    public function setIsPublic(bool $is_public): self
    {
        $this->is_public = $is_public;

        return $this;
    }

    public function getUploadedAt(): ?\DateTimeInterface
    {
        return $this->uploaded_at;
    }

    public function setUploadedAt(\DateTimeInterface $uploaded_at): self
    {
        $this->uploaded_at = $uploaded_at;

        return $this;
    }

    public function getModificatedAt(): ?\DateTimeInterface
    {
        return $this->modificated_at;
    }

    public function setModificatedAt(\DateTimeInterface $modificated_at): self
    {
        $this->modificated_at = $modificated_at;

        return $this;
    }

    public function getPhotoPath(): ?string
    {
        return $this->photo_path;
    }

    public function setPhotoPath(?string $photo_path): self
    {
        $this->photo_path = $photo_path;

        return $this;
    }
}

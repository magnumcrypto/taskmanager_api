<?php

namespace App\Entity;

use App\Repository\TaskRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TaskRepository::class)]
#[ORM\Table(name: 'tasks')]
class Task
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'task_id')]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $priority = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateInit = null;

    #[ORM\Column(length: 255)]
    private ?string $clasification = null;

    #[ORM\ManyToOne(inversedBy: 'tasks', targetEntity: Proyect::class)]
    #[ORM\JoinColumn(nullable: false, name: 'proyect_id', referencedColumnName: 'proyect_id')]
    private ?Proyect $proyect = null;

    #[ORM\Column(name: 'estimated_hours')]
    private ?int $estimatedHours = null;

    #[ORM\Column(name: 'dedicated_hours')]
    private ?int $dedicatedHours = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPriority(): ?string
    {
        return $this->priority;
    }

    public function setPriority(string $priority): static
    {
        $this->priority = $priority;

        return $this;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getDateInit(): ?\DateTimeInterface
    {
        return $this->dateInit;
    }

    public function setDateInit(\DateTimeInterface $dateInit): static
    {
        $this->dateInit = $dateInit;

        return $this;
    }

    public function getClasification(): ?string
    {
        return $this->clasification;
    }

    public function setClasification(string $clasification): static
    {
        $this->clasification = $clasification;

        return $this;
    }

    public function getProyect(): ?Proyect
    {
        return $this->proyect;
    }

    public function setProyect(?Proyect $proyect): static
    {
        $this->proyect = $proyect;

        return $this;
    }

    public function getEstimatedHours(): ?int
    {
        return $this->estimatedHours;
    }

    public function setEstimatedHours(int $estimatedHours): static
    {
        $this->estimatedHours = $estimatedHours;

        return $this;
    }

    public function getDedicatedHours(): ?int
    {
        return $this->dedicatedHours;
    }

    public function setDedicatedHours(int $dedicatedHours): static
    {
        $this->dedicatedHours = $dedicatedHours;

        return $this;
    }
}

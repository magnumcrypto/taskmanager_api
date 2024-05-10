<?php

namespace App\Entity;

use App\Repository\ProyectRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Table;

#[ORM\Entity(repositoryClass: ProyectRepository::class)]
#[Table(name: 'proyects')]
class Proyect
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(name: 'proyect_id')]
    private ?int $id = null;

    #[ORM\Column(name: 'proyect_name', length: 255)]
    private ?string $proyectName = null;

    /**
     * @var Collection<int, Task>
     */
    #[ORM\OneToMany(targetEntity: Task::class, mappedBy: 'proyect')]
    private Collection $tasks;

    public function __construct()
    {
        $this->tasks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProyectName(): ?string
    {
        return $this->proyectName;
    }

    public function setProyectName(string $proyectName): static
    {
        $this->proyectName = $proyectName;

        return $this;
    }

    /**
     * @return Collection<int, Task>
     */
    public function getTasks(): Collection
    {
        return $this->tasks;
    }

    public function addTask(Task $task): static
    {
        if (!$this->tasks->contains($task)) {
            $this->tasks->add($task);
            $task->setProyect($this);
        }

        return $this;
    }

    public function removeTask(Task $task): static
    {
        if ($this->tasks->removeElement($task)) {
            // set the owning side to null (unless already changed)
            if ($task->getProyect() === $this) {
                $task->setProyect(null);
            }
        }

        return $this;
    }
}

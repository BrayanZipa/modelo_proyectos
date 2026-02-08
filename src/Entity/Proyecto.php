<?php

namespace App\Entity;

use App\Repository\ProyectoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProyectoRepository::class)]
class Proyecto
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nombre = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    /**
     * @var Collection<int, Tarea>
     */
    #[ORM\OneToMany(targetEntity: Tarea::class, mappedBy: 'proyecto', orphanRemoval: true)]
    private Collection $tareas;

    /**
     * @var Collection<int, UsuarioProyecto>
     */
    #[ORM\OneToMany(targetEntity: UsuarioProyecto::class, mappedBy: 'proyecto', orphanRemoval: true)]
    private Collection $usuarioProyectos;

    public function __construct()
    {
        $this->createdAt = new \DateTimeImmutable();
        $this->tareas = new ArrayCollection();
        $this->usuarioProyectos = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): static
    {
        $this->nombre = $nombre;

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

    /**
     * @return Collection<int, Tarea>
     */
    public function getTareas(): Collection
    {
        return $this->tareas;
    }

    public function addTarea(Tarea $tarea): static
    {
        if (!$this->tareas->contains($tarea)) {
            $this->tareas->add($tarea);
            $tarea->setProyecto($this);
        }

        return $this;
    }

    public function removeTarea(Tarea $tarea): static
    {
        if ($this->tareas->removeElement($tarea)) {
            // set the owning side to null (unless already changed)
            if ($tarea->getProyecto() === $this) {
                $tarea->setProyecto(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, UsuarioProyecto>
     */
    public function getUsuarioProyectos(): Collection
    {
        return $this->usuarioProyectos;
    }

    public function addUsuarioProyecto(UsuarioProyecto $usuarioProyecto): static
    {
        if (!$this->usuarioProyectos->contains($usuarioProyecto)) {
            $this->usuarioProyectos->add($usuarioProyecto);
            $usuarioProyecto->setProyecto($this);
        }

        return $this;
    }

    public function removeUsuarioProyecto(UsuarioProyecto $usuarioProyecto): static
    {
        if ($this->usuarioProyectos->removeElement($usuarioProyecto)) {
            // set the owning side to null (unless already changed)
            if ($usuarioProyecto->getProyecto() === $this) {
                $usuarioProyecto->setProyecto(null);
            }
        }

        return $this;
    }
}

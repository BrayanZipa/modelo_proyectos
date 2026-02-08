<?php

namespace App\Entity;

use App\Repository\UsuarioProyectoRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UsuarioProyectoRepository::class)]
class UsuarioProyecto
{
    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'usuarioProyectos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\Id]
    #[ORM\ManyToOne(inversedBy: 'usuarioProyectos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Proyecto $proyecto = null;

    #[ORM\Column]
    private ?float $tarifa = null;

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getProyecto(): ?Proyecto
    {
        return $this->proyecto;
    }

    public function setProyecto(?Proyecto $proyecto): static
    {
        $this->proyecto = $proyecto;

        return $this;
    }

    public function getTarifa(): ?float
    {
        return $this->tarifa;
    }

    public function setTarifa(float $tarifa): static
    {
        $this->tarifa = $tarifa;

        return $this;
    }
}

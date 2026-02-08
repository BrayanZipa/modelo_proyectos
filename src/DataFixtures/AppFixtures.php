<?php

namespace App\DataFixtures;

use App\Entity\Usuario;
use App\Entity\Proyecto;
use App\Entity\Estado;
use App\Entity\Tarea;
use App\Entity\UsuarioProyecto;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager): void
    {
        // Estados
        $estados = [];
        foreach (['En espera', 'En progreso', 'Terminado'] as $nombre) {
            $estado = new Estado();
            $estado->setEstado($nombre);
            $manager->persist($estado);
            $estados[] = $estado;
        }

        // Usuarios
        $usuarios = [];
        for ($i = 1; $i <= 2; $i++) {
            $usuario = new Usuario();
            $usuario->setNombre("Usuario Test $i");
            $usuario->setEmail("test$i@mail.com");
            $usuario->setPassword("test$i");
            $manager->persist($usuario);
            $usuarios[] = $usuario;
        }

        // Proyectos
        $proyectos = [];
        for ($i = 1; $i <= 2; $i++) {
            $proyecto = new Proyecto();
            $proyecto->setNombre("Proyecto Fake $i");
            $manager->persist($proyecto);
            $proyectos[] = $proyecto;
        }

        // UsuarioProyecto (tarifas)
        foreach ($usuarios as $usuario) {
            foreach ($proyectos as $proyecto) {
                $up = new UsuarioProyecto();
                $up->setUsuario($usuario);
                $up->setProyecto($proyecto);
                $up->setTarifa(rand(100000, 1000000));
                $manager->persist($up);
            }
        }

        // tareas
        foreach ($usuarios as $usuario) {
            for ($i = 1; $i <= 20; $i++) {
                $proyecto = $proyectos[array_rand($proyectos)];
                $estado = $estados[array_rand($estados)];

                $tarea = new Tarea();
                $tarea->setUsuario($usuario);
                $tarea->setProyecto($proyecto);
                $tarea->setEstado($estado);
                $tarea->setDescripcion("Tarea Fake $i de {$usuario->getNombre()}");
                $manager->persist($tarea);
            }
        }

        $manager->flush();
    }
}

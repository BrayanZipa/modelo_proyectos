<?php

namespace App\Controller;

use App\Repository\UsuarioRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TareaController extends AbstractController
{
    #[Route('/', name: 'app_tarea')]
    public function index(UsuarioRepository $usuarioRepository): Response
    {
        $usuarios = $usuarioRepository->findAll();
        return $this->render('tarea/index.html.twig', [
            'usuarios' => $usuarios,
        ]);
    }
}

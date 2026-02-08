<?php

namespace App\Controller\Api;

use App\Repository\TareaRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

final class TareaController extends AbstractController
{
    /**
     * Obtiene todas las tareas de un usuario específico.
     *
     * @param int $id El identificador del usuario
     * @param TareaRepository $tareaRepository Repositorio de tareas
     * @return JsonResponse Respuesta JSON con las tareas del usuario
     * 
     * @throws \Exception Si el usuario no existe o hay error en la base de datos
     */
    #[Route('/api/usuarios/{id}/tareas', methods: ['GET'])]
    public function tareasUsuario(int $id, Request $request, TareaRepository $tareaRepository): JsonResponse 
    {
        $page = $request->query->get('page', 1);
        $tareas = $tareaRepository->getTareasByUsuario($id, $page);

        return $this->json(['page' => $page, 'data' => $tareas]);
    }
}

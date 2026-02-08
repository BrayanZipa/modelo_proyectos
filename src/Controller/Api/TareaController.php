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
     */
    #[Route('/api/usuarios/{id}/tareas', methods: ['GET'])]
    public function tareasUsuario(int $id, Request $request, TareaRepository $tareaRepository): JsonResponse 
    {
        $draw = $request->query->get('draw', 1);
        $start = $request->query->get('start', 0);
        $limit = $request->query->get('length', 10);
        $search = $request->query->get('search');

        $tareas = $tareaRepository->getTareasByUsuario($id, ['search' => $search], $start, $limit);
        return $this->json(['draw' => $draw, ...$tareas]);
    }
}

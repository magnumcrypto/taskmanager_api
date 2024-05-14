<?php

namespace App\Controller;

use App\Repository\ProyectRepository;
use App\Repository\TaskRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class TaskController extends AbstractController
{
    #[Route('/task/new', name: 'app_task_new', methods: ['POST'])]
    public function index(Request $request, TaskRepository $taskRepository, ProyectRepository $proyectRepo)
    {
        $taskData = json_decode($request->getContent());
        $proyect = $proyectRepo->findOneBy(['id' => 1]);
        $task = $taskRepository->createNewTask($taskData, $proyect);
        if (!$task) {
            return new JsonResponse(['msg' => 'Error en los datos, no se ha podido insertar', 'status' => 400], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['msg' => 'Nueva tarea creada', 'status' => 201], Response::HTTP_CREATED);
    }
}

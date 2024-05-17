<?php

namespace App\Controller;

use App\Entity\Proyect;
use App\Entity\Task;
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
    public function index(Request $request, TaskRepository $taskRepository, ProyectRepository $proyectRepo): JsonResponse
    {
        $taskData = json_decode($request->getContent());
        $proyect = $proyectRepo->findOneBy(['id' => 1]);
        $task = $taskRepository->createNewTask($taskData, $proyect);
        if (!$task) {
            return new JsonResponse(['msg' => 'Error en los datos, no se ha podido insertar', 'status' => 400], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['msg' => 'Nueva tarea creada', 'status' => 201], Response::HTTP_CREATED);
    }

    #[Route('/tasks/{id}', name: 'app_tasks', methods: ['GET'])]
    public function getTasks(Proyect $proyect, TaskRepository $taskRepository, ProyectRepository $proyectRepo): JsonResponse
    {
        //$proyect = $proyectRepo->findOneBy(['id' => 1]);
        $tasks = $taskRepository->getTasksJSON($proyect);
        return new JsonResponse($tasks, Response::HTTP_OK);
    }

    #[Route('/tasks/{id}', name: 'app_task_delete', methods: ['DELETE'])]
    public function delete(Task $task, TaskRepository $taskRepository): JsonResponse
    {
        $isDeleted = $taskRepository->remove($task, true);
        if (is_null($isDeleted)) {
            $response =  new JsonResponse(['msg' => 'Tarea eliminada correctamente', 'status' => 200], Response::HTTP_OK);
            $response->headers->set('Access-Control-Allow-Origin', '*');
            return $response;
        }
    }

    #[Route('/tasks/{id}', name: 'app_tasks_update', methods: ['PATCH'])]
    public function update(Task $task, Request $request, TaskRepository $taskRepository)
    {
        $taskData = json_decode($request->getContent());
        $newTask = $taskRepository->updateTask($task, $taskData);
        if (!$newTask) {
            return new JsonResponse(['msg' => 'Error en la actualización', 'status' => 401], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['msg' => 'Tarea actualizada correctamente', 'status' => 201], Response::HTTP_CREATED);
    }

    #[Route('/save', name: 'app_tasks_save_all', methods: ['PATCH'])]
    public function saveAll(Request $request, TaskRepository $taskRepository)
    {
        $data = json_decode($request->getContent());
        $isUpdated = $taskRepository->saveTasks($data);

        if (!$isUpdated) {
            return new JsonResponse(['msg' => 'Error en la actualizacion', 'status' => 400], Response::HTTP_BAD_REQUEST);
        }
        return new JsonResponse(['msg' => 'Tareas actualizadas correctamente', 'status' => 200], Response::HTTP_OK);
    }
}

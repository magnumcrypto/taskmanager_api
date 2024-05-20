<?php

namespace App\Controller;

use App\Repository\ProyectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProyectController extends AbstractController
{
    #[Route('/proyects', name: 'app_proyect_all', methods: ['GET'])]
    public function index(ProyectRepository $proyectRepository): JsonResponse
    {
        $proyects = $proyectRepository->getProyectsJSON();
        return new JsonResponse($proyects, Response::HTTP_OK);
    }

    #[Route('/proyect/new', name: 'app_proyect_new', methods: ['POST'])]
    public function create(Request $request, ProyectRepository $proyectRepository)
    {
        $proyectData = json_decode($request->getContent());
        $proyect = $proyectRepository->createProyect($proyectData);
        if (!$proyect) {
            return new JsonResponse(['msg' => 'Error en la insercion', 'status' => 401], Response::HTTP_UNAUTHORIZED);
        }
        return new JsonResponse(['msg' => 'Proyecto creado exitosamente', 'status' => 200], Response::HTTP_OK);
    }
}

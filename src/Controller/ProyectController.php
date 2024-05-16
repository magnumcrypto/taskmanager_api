<?php

namespace App\Controller;

use App\Repository\ProyectRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProyectController extends AbstractController
{
    #[Route('/proyects', name: 'app_proyect_all', methods: ['GET'])]
    public function index(ProyectRepository $proyectRepository)
    {
        $proyects = $proyectRepository->getProyectsJSON();
        return new JsonResponse($proyects, Response::HTTP_OK);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Bundle\SecurityBundle\Security;
use App\Entity\Ordenes;
use App\Repository\OrdenesRepository;
use App\Repository\UsuariosRepository;
use App\Entity\Direcciones;

class OrdenesController extends AbstractController
{
    
    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private Security $security;
    private OrdenesRepository $ordenesRepository;
    private UsuariosRepository $usuariosRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        OrdenesRepository $ordenesRepository,
        UsuariosRepository $usuariosRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
        $this->ordenesRepository = $ordenesRepository;
        $this->usuariosRepository = $usuariosRepository;
    }


    #[Route('/ordenes', name: 'get_ordenes', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->ordenesRepository->findAll();

        return $this->json($result);
    }

    #[Route('/ordenes', name: 'crear-ordenes', methods: ['POST'])]
    public function crearOrden(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Validación de los datos
            $requiredFields = ['usuario_id', 'calle', 'ciudad', 'estado', 'codigoPostal', 'pais'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    return $this->json(['status' => 'error', 'message' => 'El campo ' . $field . ' es obligatorio'], Response::HTTP_BAD_REQUEST);
                }
            }

            // Buscar el usuario
            $usuario = $this->usuariosRepository->find($data['usuario_id']);
            if (!$usuario) {
                return $this->json(['status' => 'error', 'message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
            }

            // Crear la dirección
            $orden = new Ordenes();
            $orden->setUsuario($usuario);
            $orden->setCalle($data['calle']);
            $orden->setCiudad($data['ciudad']);
            $orden->setEstado($data['estado']);
            $orden->setCodigoPostal($data['codigoPostal']);
            $orden->setPais($data['pais']);

            // Guardar la dirección
            $this->entityManager->persist($orden);
            $this->entityManager->flush();

            return $this->json($orden->getOrdenesId(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log("Error al crear la dirección: " . $e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear la dirección: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}

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
use App\Entity\Usuarios;
use App\Repository\DireccionesRepository;
use App\Repository\UsuariosRepository;
use App\Entity\Direcciones;


class UsuariosController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private Security $security;
    private DireccionesRepository $direccionesRepository;
    private UsuariosRepository $usuariosRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        DireccionesRepository $direccionesRepository,
        UsuariosRepository $usuariosRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
        $this->direccionesRepository = $direccionesRepository;
        $this->usuariosRepository = $usuariosRepository;
    }


    #[Route('/usuarios', name: 'get_usuarios', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->usuariosRepository->findAll();

        return $this->json($result);
    }

    #[Route('/usuarios', name: 'crear-usuarios', methods: ['POST'])]
    public function crearDireccion(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Validación de los datos
            $requiredFields = ['nombre', 'email', 'password', 'telefono', 'direcciones', 'ordenes'];
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
            $direccion = new Direcciones();
            $direccion->setUsuario($usuario);
            $direccion->setCalle($data['calle']);
            $direccion->setCiudad($data['ciudad']);
            $direccion->setEstado($data['estado']);
            $direccion->setCodigoPostal($data['codigoPostal']);
            $direccion->setPais($data['pais']);

            // Guardar la dirección
            $this->entityManager->persist($direccion);
            $this->entityManager->flush();

            return $this->json($direccion->getDireccionesId(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log("Error al crear la dirección: " . $e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear la dirección: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}

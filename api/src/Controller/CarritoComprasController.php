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
use App\Repository\CarritoComprasRepository;
use App\Repository\UsuariosRepository;
use App\Entity\Direcciones;
use App\Entity\CarritoCompras;


class CarritoComprasController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private Security $security;
    private CarritoComprasRepository $carritoComprasRepository;
    private UsuariosRepository $usuariosRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        CarritoComprasRepository $carritoComprasRepository,
        UsuariosRepository $usuariosRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
        $this->carritoComprasRepository = $carritoComprasRepository;
        $this->usuariosRepository = $usuariosRepository;
    }

    #[Route('/carritoCompra', name: 'get_carritoCompra', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->carritoComprasRepository->findAll();

        return $this->json($result);
    }

    #[Route('/carritos-compras', name: 'crear_carrito_compras', methods: ['POST'])]
    public function crearCarritoCompras(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);
    
            // Crear una nueva instancia de CarritoCompras
            $carritoCompras = new CarritoCompras();
    
            // Verificar si se proporciona un usuario y buscarlo en la base de datos
            if (isset($data['usuario_id'])) {
                $usuario = $this->usuariosRepository->find($data['usuario_id']);
                if (!$usuario) {
                    return $this->json(['status' => 'error', 'message' => 'Usuario no encontrado'], Response::HTTP_NOT_FOUND);
                }
                $carritoCompras->setUsuario($usuario);
            }
    
            // Establecer el total del carrito de compras (si se proporciona)
            if (isset($data['total'])) {
                $carritoCompras->setTotal($data['total']);
            }
    
            // Persistir el carrito de compras en la base de datos
            $this->entityManager->persist($carritoCompras);
            $this->entityManager->flush();
    
            // Devolver una respuesta con el ID del carrito creado
            return $this->json(['status' => 'success', 'carrito_id' => $carritoCompras->getCarritoId()], Response::HTTP_CREATED);
        } catch (\Exception $e) {
            // Manejar cualquier excepción que ocurra durante el proceso
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear el carrito de compras: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    
}

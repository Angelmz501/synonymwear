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
use App\Repository\ProductosRepository;
use App\Repository\UsuariosRepository;
use App\Entity\Productos;
use App\Repository\CategoriasRepository;

class ProductosController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private Security $security;
    private ProductosRepository $productosRepository;
    private UsuariosRepository $usuariosRepository;
    private CategoriasRepository $categoriasRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        ProductosRepository $productosRepository,
        UsuariosRepository $usuariosRepository,
        CategoriasRepository $categoriasRepository,
    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
        $this->productosRepository = $productosRepository;
        $this->usuariosRepository = $usuariosRepository;
        $this->categoriasRepository = $categoriasRepository;
    }


    #[Route('/productos', name: 'get_productos', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->productosRepository->findAll();

        return $this->json($result);
    }

    
    #[Route('/productos', name: 'crear-producto', methods: ['POST'])]
    public function crearProducto(Request $request): Response
    {
        try {
            $data = json_decode($request->getContent(), true);

            // Validación de los datos
            $requiredFields = ['nombre', 'descripcion', 'precio', 'talla', 'color', 'cantidadInventario', 'categoria', 'historialInventario'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field])) {
                    return $this->json(['status' => 'error', 'message' => 'El campo ' . $field . ' es obligatorio'], Response::HTTP_BAD_REQUEST);
                }
            }

            // Buscar el usuario
            $categoria = $this->categoriasRepository->find($data['usuario_id']);
            if (!$categoria) {
                return $this->json(['status' => 'error', 'message' => 'Categoria no encontrada'], Response::HTTP_NOT_FOUND);
            }

            // Crear la dirección
            $producto = new Productos();
            $producto->setCategoria($categoria);
            $producto->setNombre($data['nombre']);
            $producto->setDescripcion($data['descripcion']);
            $producto->setPrecio($data['precio']);
            $producto->setTalla($data['talla']);
            $producto->setColor($data['color']);
            $producto->setCantidadInventario($data['cantidadInventario']);
            $producto->addHistorialInventario($data['historialInventario']);

            // Guardar la dirección
            $this->entityManager->persist($producto);
            $this->entityManager->flush();

            return $this->json($producto->getProductosId(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log("Error al crear el producto: " . $e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear el producto: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/productos/{id}', name: 'delete_producto', methods: ['DELETE'])]
    public function deleteProducto(int $id): Response
    {
        try {
            $producto = $this->productosRepository->find($id);
            if (!$producto) {
                return $this->json(['status' => 'error', 'message' => 'producto no encontrado'], Response::HTTP_NOT_FOUND);
            }

            // Eliminar la dirección
            $this->entityManager->remove($producto);
            $this->entityManager->flush();

            return $this->json(['status' => 'success', 'message' => 'Producto eliminado correctamente'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Error al eliminar el producto (DELETE): ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


}

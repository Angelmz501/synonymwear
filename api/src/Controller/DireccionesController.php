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

class DireccionesController extends AbstractController
{

    private EntityManagerInterface $entityManager;
    private SerializerInterface $serializer;
    private ValidatorInterface $validator;
    private Security $security;
    private DireccionesRepository $direccionesRepository;

    public function __construct(
        EntityManagerInterface $entityManager,
        SerializerInterface $serializer,
        ValidatorInterface $validator,
        Security $security,
        DireccionesRepository $direccionesRepository

    ) {
        $this->entityManager = $entityManager;
        $this->serializer = $serializer;
        $this->validator = $validator;
        $this->security = $security;
        $this->direccionesRepository = $direccionesRepository;

    }

    #[Route('/direcciones', name: 'get_direcciones', methods: ['GET'])]
    public function index(): Response
    {
        $result = $this->direccionesRepository->findAll();

        return $this->json($result);
    }

    #[Route('/partidas-presupuestarias', name: 'crear-partida-presupuestaria', methods: ['POST'])]
    public function crearPartidaPresupuestaria(Request $request): Response
    {
        try {



         } catch (\Exception $e) {
            error_log("Error al crear la direccion: " . $e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear la direccion: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    #[Route('/partidas-presupuestarias', name: 'crear-partida-presupuestaria', methods: ['POST'])]
    public function crearPartidaPresupuestaria(Request $request): Response
    {
        try {
            $partidaPresupuestariaComprobada = $this->serializer->deserialize(
                $request->getContent(),
                PartidasPresupuestariasDTO::class,
                'json'
            );



            $errors = $this->validator->validate($partidaPresupuestariaComprobada);
            if (count($errors) > 0) {
                $errorMessages = [];
                foreach ($errors as $error) {
                    $errorMessages[$error->getPropertyPath()] = $error->getMessage();
                }
                return $this->json(['status' => 'error', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
            }

            $organo = $this->OrganoRepository->find($partidaPresupuestariaComprobada->organo);
            if (!$organo) {
                return $this->json(['status' => 'error', 'message' => 'Órgano no encontrado'], Response::HTTP_NOT_FOUND);
            }

            $newPartidaPresupuestaria = $this->partidasPresupuestariasRepository->createPartidaPresupuestaria($partidaPresupuestariaComprobada, $organo);

            if ($newPartidaPresupuestaria === null) {
                return $this->json(['status' => 'error', 'message' => 'Failed to create the budgetary item'], Response::HTTP_INTERNAL_SERVER_ERROR);
            }

            $partidaPresupuestariaHist = new PartidasPresupuestariasHist();
            $partidaPresupuestariaHist->setOrgano($organo);
            $partidaPresupuestariaHist->setPresupuesto($partidaPresupuestariaComprobada->presupuesto);
            $partidaPresupuestariaHist->setNombre($partidaPresupuestariaComprobada->nombre);
            $partidaPresupuestariaHist->setDescripcion($partidaPresupuestariaComprobada->descripcion);
            $partidaPresupuestariaHist->setEjercicio($partidaPresupuestariaComprobada->ejercicio);
            $partidaPresupuestariaHist->setSaldoDisponible($partidaPresupuestariaComprobada->saldo_disponible);

            $usuario = $this->security->getUser();
            if (!$usuario || !$usuario instanceof Usuario) {
                throw new \Exception("No se ha podido identificar al usuario autenticado.");
            }

            $partidaPresupuestariaHist->setUsuarioAlta($usuario->getUsuarioId());
            $partidaPresupuestariaHist->setPartidasPresupuestariasId($newPartidaPresupuestaria->getPartidasPresupuestariasId());
            $partidaPresupuestariaHist->setFechaAlta(new \DateTime());

            // Guardar el registro histórico
            $this->entityManager->persist($partidaPresupuestariaHist);
            $this->entityManager->flush();

            return $this->json($newPartidaPresupuestaria->getNombre(), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            error_log("Error al crear la partida presupuestaria: " . $e->getMessage());
            return $this->json([
                'status' => 'error',
                'message' => 'Error al crear la partida presupuestaria: ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }


    // #[Route('/crear-partida-presupuestaria', name: 'crear-partida-presupuestaria', methods: ['POST'])]
    // public function crearPartidaPresupuestaria(Request $request): Response
    // {
    //     try {

    //         $partidaPresupuestariaComprobada = $this->serializer->deserialize(
    //             $request->getContent(),
    //             PartidasPresupuestariasDTO::class,
    //             'json'
    //         );

    //         $errors = $this->validator->validate($partidaPresupuestariaComprobada);
    //         if (count($errors) > 0) {
    //             $errorMessages = [];
    //             foreach ($errors as $error) {
    //                 $errorMessages[$error->getPropertyPath()] = $error->getMessage();
    //             }
    //             return $this->json(['status' => 'error', 'errors' => $errorMessages], Response::HTTP_BAD_REQUEST);
    //         }

    //         // Búsqueda del órgano asociado al id proporcionado
    //         $organo = $this->OrganoRepository->find($partidaPresupuestariaComprobada->organo_id);
    //         if (!$organo) {
    //             return $this->json(['status' => 'error', 'message' => 'Órgano no encontrado'], Response::HTTP_NOT_FOUND);
    //         }

    //         $newPartidaPresupuestaria = $this->partidasPresupuestariasRepository->createPartidaPresupuestaria($partidaPresupuestariaComprobada, $organo);

    //         return $this->json($newPartidaPresupuestaria->getNombre(), Response::HTTP_CREATED);

    //     } catch (\Exception $e) {
    //         // Registro del error en caso de excepción
    //         error_log("Error al crear la partida presupuestaria: " . $e->getMessage());
    //         return $this->json([
    //             'status' => 'error',
    //             'message' => 'Error al crear la partida presupuestaria: ' . $e->getMessage()
    //         ], Response::HTTP_INTERNAL_SERVER_ERROR);
    //     }
    // }


    #[Route('/partidas-presupuestarias/{id}', name: 'patch_partida_presupuestaria', methods: ['PATCH'])]
    public function patchPartidasPresupuestarias(int $id, Request $request): Response
    {
        try {
            $partidaPresupuestaria = $this->partidasPresupuestariasRepository->find($id);
            if (!$partidaPresupuestaria) {
                return $this->json(['status' => 'error', 'message' => 'Partida presupuestaria no encontrada'], Response::HTTP_NOT_FOUND);
            }
    
            $partidaPresupuestariaComprobada = $this->serializer->deserialize($request->getContent(), PartidasPresupuestariasDTO::class, 'json');
            $patchData = json_decode($request->getContent(), true);
    
            // Actualización de propiedades según los datos proporcionados
            $changes = false; // Flag para detectar cambios
            if (isset($patchData['nombre'])) {
                $partidaPresupuestaria->setNombre($partidaPresupuestariaComprobada->nombre);
                $changes = true;
            }
            if (isset($patchData['descripcion'])) {
                $partidaPresupuestaria->setDescripcion($partidaPresupuestariaComprobada->descripcion);
                $changes = true;
            }
            if (isset($patchData['organo'])) {
                $organo = $this->OrganoRepository->find($partidaPresupuestariaComprobada->organo);
                if (!$organo) {
                    return $this->json(['status' => 'error', 'message' => 'Órgano no encontrado'], Response::HTTP_NOT_FOUND);
                }
                $partidaPresupuestaria->setOrgano($organo);
                $changes = true;
            }
            if (isset($patchData['ejercicio'])) {
                $partidaPresupuestaria->setEjercicio($partidaPresupuestariaComprobada->ejercicio);
                $changes = true;
            }

            if (isset($patchData['presupuesto']) && $partidaPresupuestariaComprobada->presupuesto !== null) {
                $partidaPresupuestaria->setPresupuesto($partidaPresupuestariaComprobada->presupuesto);
                $changes = true;
            }

            if (isset($patchData['saldo_disponible']) && $partidaPresupuestariaComprobada->saldo_disponible !== null) {
                $partidaPresupuestaria->setSaldoDisponible($partidaPresupuestariaComprobada->saldo_disponible);
                $changes = true;
            }

            // Repetir para otras propiedades según sea necesario
    
            if (!$changes) {
                return $this->json(['status' => 'info', 'message' => 'No hubo cambios para actualizar.']);
            }
    
            // Validar el objeto después de las modificaciones
            $errors = $this->validator->validate($partidaPresupuestaria);
            if (count($errors) > 0) {
                return $this->json(['status' => 'error', 'errors' => $this->utils->formatValidationErrors($errors)], Response::HTTP_BAD_REQUEST);
            }
    
            // Persistir los cambios
            $this->entityManager->persist($partidaPresupuestaria);
            $this->entityManager->flush();
    
            // Crear y guardar el registro histórico
            $partidaPresupuestariaHist = new PartidasPresupuestariasHist();
            $partidaPresupuestariaHist->setPartidasPresupuestariasId($partidaPresupuestaria->getPartidasPresupuestariasId());
            $partidaPresupuestariaHist->setPresupuesto($partidaPresupuestaria->getPresupuesto());
            $partidaPresupuestariaHist->setNombre($partidaPresupuestaria->getNombre());
            $partidaPresupuestariaHist->setDescripcion($partidaPresupuestaria->getDescripcion());
            $partidaPresupuestariaHist->setEjercicio($partidaPresupuestaria->getEjercicio());
            $partidaPresupuestariaHist->setSaldoDisponible($partidaPresupuestaria->getSaldoDisponible());
    
            $usuario = $this->security->getUser();
            if (!$usuario || !$usuario instanceof Usuario) {
                throw new \Exception("No se ha podido identificar al usuario autenticado.");
            }
    
            $partidaPresupuestariaHist->setUsuarioAlta($usuario->getUsuarioId());
            $partidaPresupuestariaHist->setFechaModificacion(new \DateTime());
    
            // Guardar el registro histórico
            $this->entityManager->persist($partidaPresupuestariaHist);
            $this->entityManager->flush();
    
            return $this->json(['status' => 'success', 'message' => 'Partida presupuestaria modificada con éxito y registro histórico creado'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Se ha producido un error al modificar la partida presupuestaria (PATCH): ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

    #[Route('/partidas-presupuestarias/{id}', name: 'delete_partidas_presupuestarias', methods: ['DELETE'])]
    public function deletePartidasPresupuestarias(int $id): Response
    {
        try {
            $partidaPresupuestaria = $this->partidasPresupuestariasRepository->find($id);
            if (!$partidaPresupuestaria) { // Si no existe lanzo un error
                return $this->json(['status' => 'error', 'message' => 'Partida presupuestaria no encontrada'], Response::HTTP_NOT_FOUND);
            }
    
            // Crear registro histórico antes de eliminar
            $partidaPresupuestariaHist = new PartidasPresupuestariasHist();
            $partidaPresupuestariaHist->setPartidasPresupuestariasId($partidaPresupuestaria->getPartidasPresupuestariasId());
            $partidaPresupuestariaHist->setPresupuesto($partidaPresupuestaria->getPresupuesto());
            $partidaPresupuestariaHist->setNombre($partidaPresupuestaria->getNombre());
            $partidaPresupuestariaHist->setDescripcion($partidaPresupuestaria->getDescripcion());
            $partidaPresupuestariaHist->setEjercicio($partidaPresupuestaria->getEjercicio());
            $partidaPresupuestariaHist->setSaldoDisponible($partidaPresupuestaria->getSaldoDisponible());
    
            $usuario = $this->security->getUser();
            if (!$usuario || !$usuario instanceof Usuario) {
                throw new \Exception("No se ha podido identificar al usuario autenticado.");
            }
    
            $partidaPresupuestariaHist->setUsuarioAlta($usuario->getUsuarioId());
            $partidaPresupuestariaHist->setFechaModificacion(new \DateTime());
    
            // Guardar el registro histórico
            $this->entityManager->persist($partidaPresupuestariaHist);
            $this->entityManager->flush();
    
            // Ahora eliminar la partida presupuestaria original
            $this->entityManager->remove($partidaPresupuestaria);
            $this->entityManager->flush();
    
            return $this->json(['status' => 'success', 'message' => 'Partida presupuestaria eliminada con registro histórico guardado'], Response::HTTP_OK);
        } catch (\Exception $e) {
            return $this->json([
                'status' => 'error',
                'message' => 'Error al eliminar la partida presupuestaria (DELETE): ' . $e->getMessage()
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    

}

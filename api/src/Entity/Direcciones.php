<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity]
class Direcciones
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $direcciones_id = null;

    #[ORM\ManyToOne(targetEntity: Usuarios::class, inversedBy: 'direcciones')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuarios $usuario = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $calle = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $ciudad = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $estado = null;

    #[ORM\Column(type: 'string', length: 20)]
    private ?string $codigoPostal = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $pais = null;

    // Getters y Setters
}

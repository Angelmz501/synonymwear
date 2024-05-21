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

    public function getDireccionesId(): ?int
    {
        return $this->direcciones_id;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuarios $usuario): self
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getCalle(): ?string
    {
        return $this->calle;
    }

    public function setCalle(string $calle): self
    {
        $this->calle = $calle;

        return $this;
    }

    public function getCiudad(): ?string
    {
        return $this->ciudad;
    }

    public function setCiudad(string $ciudad): self
    {
        $this->ciudad = $ciudad;

        return $this;
    }

    public function getEstado(): ?string
    {
        return $this->estado;
    }

    public function setEstado(string $estado): self
    {
        $this->estado = $estado;

        return $this;
    }

    public function getCodigoPostal(): ?string
    {
        return $this->codigoPostal;
    }

    public function setCodigoPostal(string $codigoPostal): self
    {
        $this->codigoPostal = $codigoPostal;

        return $this;
    }

    public function getPais(): ?string
    {
        return $this->pais;
    }

    public function setPais(string $pais): self
    {
        $this->pais = $pais;

        return $this;
    }
}

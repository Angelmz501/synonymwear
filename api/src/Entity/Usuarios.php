<?php

namespace App\Entity;

use App\Repository\UsuariosRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity(repositoryClass: UsuariosRepository::class)]
class Usuarios
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $usuario_id = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $nombre = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $password = null;

    #[ORM\Column(type: 'string', length: 20, nullable: true)]
    private ?string $telefono = null;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Direcciones::class)]
    private Collection $direcciones;

    #[ORM\OneToMany(mappedBy: 'usuario', targetEntity: Ordenes::class)]
    private Collection $ordenes;

    public function __construct()
    {
        $this->direcciones = new ArrayCollection();
        $this->ordenes = new ArrayCollection();
    }

    // Getters and Setters
  
    #[SerializedName("usuario_id")]
    public function getUsuarioId(): ?int
    {
        return $this->usuario_id;
    }

    public function getNombre(): ?string
    {
        return $this->nombre;
    }

    public function setNombre(string $nombre): self
    {
        $this->nombre = $nombre;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function getTelefono(): ?string
    {
        return $this->telefono;
    }

    public function setTelefono(?string $telefono): self
    {
        $this->telefono = $telefono;

        return $this;
    }

    /**
     * @return Collection|Direcciones[]
     */
    public function getDirecciones(): Collection
    {
        return $this->direcciones;
    }

    public function addDireccion(Direcciones $direccion): self
    {
        if (!$this->direcciones->contains($direccion)) {
            $this->direcciones[] = $direccion;
            $direccion->setUsuario($this);
        }

        return $this;
    }

    public function removeDireccion(Direcciones $direccion): self
    {
        if ($this->direcciones->removeElement($direccion)) {
            // set the owning side to null (unless already changed)
            if ($direccion->getUsuario() === $this) {
                $direccion->setUsuario(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ordenes[]
     */
    public function getOrdenes(): Collection
    {
        return $this->ordenes;
    }

    public function addOrden(Ordenes $orden): self
    {
        if (!$this->ordenes->contains($orden)) {
            $this->ordenes[] = $orden;
            $orden->setUsuario($this);
        }

        return $this;
    }

    public function removeOrden(Ordenes $orden): self
    {
        if ($this->ordenes->removeElement($orden)) {
            // set the owning side to null (unless already changed)
            if ($orden->getUsuario() === $this) {
                $orden->setUsuario(null);
            }
        }

        return $this;
    }

}

<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\SerializedName;

#[ORM\Entity]
class CarritoCompras
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private ?int $carrito_id = null;

    #[ORM\OneToOne(targetEntity: Usuarios::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(name: "usuario_id", referencedColumnName: "usuario_id")]
    private ?Usuarios $usuario_id = null;

    #[ORM\Column(type: 'float')]
    private ?float $total = null;

    #[ORM\OneToMany(mappedBy: 'carrito', targetEntity: ProductosCarrito::class)]
    private Collection $productosCarrito;

    public function __construct()
    {
        $this->productosCarrito = new ArrayCollection();
    }

    // Getters y Setters

    #[SerializedName("carrito_id")]
    public function getCarritoId(): ?int
    {
        return $this->carrito_id;
    }

    public function getUsuario(): ?Usuarios
    {
        return $this->usuario_id;
    }

    public function setUsuario(?Usuarios $usuario_id): self
    {
        $this->usuario_id = $usuario_id;

        return $this;
    }

    public function getTotal(): ?float
    {
        return $this->total;
    }

    public function setTotal(float $total): self
    {
        $this->total = $total;

        return $this;
    }

    /**
     * @return Collection|ProductosCarrito[]
     */
    public function getProductosCarrito(): Collection
    {
        return $this->productosCarrito;
    }

    public function addProductoCarrito(ProductosCarrito $productoCarrito): self
    {
        if (!$this->productosCarrito->contains($productoCarrito)) {
            $this->productosCarrito[] = $productoCarrito;
            $productoCarrito->setCarrito($this);
        }

        return $this;
    }

    public function removeProductoCarrito(ProductosCarrito $productoCarrito): self
    {
        if ($this->productosCarrito->removeElement($productoCarrito)) {
            // set the owning side to null (unless already changed)
            if ($productoCarrito->getCarrito() === $this) {
                $productoCarrito->setCarrito(null);
            }
        }

        return $this;
    }
}

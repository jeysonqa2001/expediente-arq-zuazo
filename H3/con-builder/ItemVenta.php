<?php

declare(strict_types=1);

namespace App\ConBuilder;

final class ItemVenta
{
    public function __construct(
        private readonly int $idItem,
        private readonly Producto $producto,
        private readonly int $cantidad
    ) {
        if ($cantidad <= 0) {
            throw new \InvalidArgumentException('La cantidad debe ser mayor a 0.');
        }
    }

    public function getIdItem(): int
    {
        return $this->idItem;
    }

    public function getProducto(): Producto
    {
        return $this->producto;
    }

    public function getCantidad(): int
    {
        return $this->cantidad;
    }

    public function calcularSubtotal(): float
    {
        return $this->producto->getPrecio() * $this->cantidad;
    }
}

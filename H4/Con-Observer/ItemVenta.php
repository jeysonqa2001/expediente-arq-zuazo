<?php

declare(strict_types=1);

namespace App\ConObserver;

/**
 * ItemVenta
 *
 * SRP: su unica responsabilidad es representar una linea de venta
 * (un producto + una cantidad) y saber calcular su propio subtotal.
 * No sabe nada de la Venta completa ni del total general; eso es
 * responsabilidad de Venta (cada clase calcula solo lo que le
 * corresponde a su propio nivel).
 *
 * DIP: ItemVenta depende de Producto a traves de una referencia ya
 * construida (se la pasan por constructor), no crea el Producto por
 * su cuenta. Esto deja la puerta abierta a que, en con-factory/,
 * la creacion de Producto se delegue a una fabrica sin tener que
 * tocar esta clase.
 */
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

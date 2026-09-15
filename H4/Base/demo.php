<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/Venta.php';

use App\Base\Usuario;
use App\Base\Producto;
use App\Base\ItemVenta;
use App\Base\Venta;


$usuario = new Usuario(idUsuario: 1, nombre: 'Jeyson', email: 'jeyson@gmail.com');

$producto1 = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 35.50);
$producto2 = new Producto(idProducto: 2, sku: 'SKU-002', nombre: 'Galletas Marilan', precio: 8.00);
$producto3 = new Producto(idProducto: 3, sku: 'SKU-002', nombre: 'Next Menta', precio: 10.00);

$venta = new Venta(
    idVenta: 1,
    usuario: $usuario,
    fecha: new \DateTimeImmutable('now')
);

$venta->agregarItem(new ItemVenta(idItem: 1, producto: $producto1, cantidad: 2));
$venta->agregarItem(new ItemVenta(idItem: 2, producto: $producto2, cantidad: 1));
$venta->agregarItem(new ItemVenta(idItem: 3, producto: $producto3, cantidad: 1));

echo "--- Venta #{$venta->getIdVenta()} ---\n";
echo "Cliente: {$venta->getUsuario()->getNombre()}\n";
echo "Fecha: {$venta->getFecha()->format('Y-m-d H:i')}\n";
echo "Items:\n";

foreach ($venta->getItems() as $item) {
    $nombre = $item->getProducto()->getNombre();
    $cantidad = $item->getCantidad();
    $subtotal = number_format($item->calcularSubtotal(), 2);
    echo "  - {$nombre} x{$cantidad} = Bs {$subtotal}\n";
}

$total = number_format($venta->calcularTotal(), 2);
echo "TOTAL: Bs {$total}\n";

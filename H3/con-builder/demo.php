<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/Venta.php';
require_once __DIR__ . '/VentaBuilder.php';

use App\ConBuilder\Usuario;
use App\ConBuilder\Producto;
use App\ConBuilder\VentaBuilder;

$usuario = new Usuario(idUsuario: 1, nombre: 'Jeyson', email: 'jeyson@example.com');

$producto1 = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 6.50);
$producto2 = new Producto(idProducto: 2, sku: 'SKU-002', nombre: 'Galletas Marilan', precio: 12.00);
$producto3 = new Producto(idProducto: 3, sku: 'SKU-007', nombre: 'Cobertura chocolate semiamargo con leche 1kg', precio: 60.00);

$venta = (new VentaBuilder())
    ->paraVenta(1)
    ->paraUsuario($usuario)
    ->conFecha(new \DateTimeImmutable('now'))
    ->agregarItem($producto1, 2)
    ->agregarItem($producto2, 1)
    ->agregarItem($producto3, 1)
    ->build();

echo "--- Venta #{$venta->getIdVenta()} ---\n";
echo "Cliente: {$venta->getUsuario()->getNombre()}\n";
echo "Items:\n";

foreach ($venta->getItems() as $item) {
    $nombre = $item->getProducto()->getNombre();
    $cantidad = $item->getCantidad();
    $subtotal = number_format($item->calcularSubtotal(), 2);
    echo "  - {$nombre} x{$cantidad} = Bs {$subtotal}\n";
}

echo 'TOTAL: Bs ' . number_format($venta->calcularTotal(), 2) . "\n";

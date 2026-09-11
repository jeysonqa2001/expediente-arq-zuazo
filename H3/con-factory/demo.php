<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/ProcesadorPago.php';
require_once __DIR__ . '/FabricaPago.php';
require_once __DIR__ . '/Venta.php';

use App\ConFactory\Usuario;
use App\ConFactory\Producto;
use App\ConFactory\ItemVenta;
use App\ConFactory\Venta;

$usuario = new Usuario(idUsuario: 1, nombre: 'Jeyson', email: 'jeyson@example.com');

$producto1 = new Producto(idProducto: 1, sku: 'SKU-004', nombre: 'Papas Pringles', precio: 25.00);
$producto2 = new Producto(idProducto: 2, sku: 'SKU-003', nombre: 'Masticable Next', precio: 3.50);

$venta = new Venta(
    idVenta: 1,
    usuario: $usuario,
    fecha: new \DateTimeImmutable('now'),
    tipoPago: 'tarjeta'
);

$venta->agregarItem(new ItemVenta(idItem: 1, producto: $producto1, cantidad: 2));
$venta->agregarItem(new ItemVenta(idItem: 2, producto: $producto2, cantidad: 1));

echo "--- Venta #{$venta->getIdVenta()} ---\n";
echo "Total: Bs " . number_format($venta->calcularTotal(), 2) . "\n";
echo "Procesando pago...\n";

$exitoso = $venta->procesarPago();
echo 'Resultado: ' . ($exitoso ? 'APROBADO' : 'RECHAZADO') . "\n";

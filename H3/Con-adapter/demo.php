<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/ProcesadorPago.php';
require_once __DIR__ . '/PasarelaPagoExternaSDK.php';
require_once __DIR__ . '/AdaptadorPasarelaTarjeta.php';
require_once __DIR__ . '/Venta.php';

use App\ConAdapter\Usuario;
use App\ConAdapter\Producto;
use App\ConAdapter\ItemVenta;
use App\ConAdapter\AdaptadorPasarelaTarjeta;
use App\ConAdapter\Venta;

$usuario = new Usuario(idUsuario: 1, nombre: 'Jeyson', email: 'jeyson@example.com');

$producto1 = new Producto(idProducto: 1, sku: 'SKU-005', nombre: 'Cobertura chocolate blanco 1kg', precio: 55.00);
$producto2 = new Producto(idProducto: 2, sku: 'SKU-006', nombre: 'Cobertura chocolate semiamargo 1kg', precio: 58.00);

$adaptador = new AdaptadorPasarelaTarjeta(cardToken: 'tok_visa_1234');

$venta = new Venta(
    idVenta: 1,
    usuario: $usuario,
    fecha: new \DateTimeImmutable('now'),
    procesador: $adaptador
);

$venta->agregarItem(new ItemVenta(idItem: 1, producto: $producto1, cantidad: 2));
$venta->agregarItem(new ItemVenta(idItem: 2, producto: $producto2, cantidad: 1));

echo "--- Venta #{$venta->getIdVenta()} ---\n";
echo "Total: Bs " . number_format($venta->calcularTotal(), 2) . "\n";
echo "Procesando pago (via SDK externo adaptado)...\n";

$exitoso = $venta->procesarPago();
echo 'Resultado: ' . ($exitoso ? 'APROBADO' : 'RECHAZADO') . "\n";

<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/ObservadorVenta.php';
require_once __DIR__ . '/Venta.php';
require_once __DIR__ . '/NotificadorCliente.php';
require_once __DIR__ . '/ControlInventario.php';
require_once __DIR__ . '/RegistroVentas.php';

use App\ConObserver\Usuario;
use App\ConObserver\Producto;
use App\ConObserver\ItemVenta;
use App\ConObserver\Venta;
use App\ConObserver\NotificadorCliente;
use App\ConObserver\ControlInventario;
use App\ConObserver\RegistroVentas;

// ---------- Catalogo de la tienda ----------
$cholike     = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 6.50);
$marilan     = new Producto(idProducto: 2, sku: 'SKU-002', nombre: 'Galletas Marilan', precio: 12.00);
$next        = new Producto(idProducto: 3, sku: 'SKU-003', nombre: 'Masticable Next', precio: 3.50);
$pringles    = new Producto(idProducto: 4, sku: 'SKU-004', nombre: 'Papas Pringles', precio: 25.00);
$cobBlanco   = new Producto(idProducto: 5, sku: 'SKU-005', nombre: 'Cobertura chocolate blanco 1kg', precio: 55.00);
$cobSemi     = new Producto(idProducto: 6, sku: 'SKU-006', nombre: 'Cobertura chocolate semiamargo 1kg', precio: 58.00);

// ---------- Observadores (se crean UNA vez y se reutilizan) ----------
$notificador = new NotificadorCliente();

$inventario = new ControlInventario([
    'SKU-001' => 40,  // Cholike
    'SKU-002' => 25,  // Marilan
    'SKU-003' => 60,  // Next
    'SKU-004' => 8,   // Pringles (poco stock, va a disparar alerta)
    'SKU-005' => 10,  // Cobertura blanca
    'SKU-006' => 12,  // Cobertura semiamarga
]);

$registro = new RegistroVentas();

// ============ VENTA 1 ============
$cliente1 = new Usuario(idUsuario: 1, nombre: 'Maria Quispe', email: 'maria@example.com');

$venta1 = new Venta(idVenta: 1, usuario: $cliente1, fecha: new \DateTimeImmutable('now'));

// Se suscriben los 3 observadores al evento de esta venta
$venta1->suscribir($notificador);
$venta1->suscribir($inventario);
$venta1->suscribir($registro);

$venta1->agregarItem(new ItemVenta(idItem: 1, producto: $cholike, cantidad: 3));
$venta1->agregarItem(new ItemVenta(idItem: 2, producto: $pringles, cantidad: 4));

echo "========== CONFIRMANDO VENTA #1 ==========\n";
$venta1->confirmar();  // <-- aqui se dispara el EVENTO

echo "\n";

// ============ VENTA 2 ============
$cliente2 = new Usuario(idUsuario: 2, nombre: 'Carlos Mamani', email: 'carlos@example.com');

$venta2 = new Venta(idVenta: 2, usuario: $cliente2, fecha: new \DateTimeImmutable('now'));

$venta2->suscribir($notificador);
$venta2->suscribir($inventario);
$venta2->suscribir($registro);

$venta2->agregarItem(new ItemVenta(idItem: 1, producto: $cobSemi, cantidad: 2));
$venta2->agregarItem(new ItemVenta(idItem: 2, producto: $marilan, cantidad: 5));
$venta2->agregarItem(new ItemVenta(idItem: 3, producto: $next, cantidad: 10));

echo "========== CONFIRMANDO VENTA #2 ==========\n";
$venta2->confirmar();

echo "\n========== CIERRE DEL DIA ==========\n";
echo "Ventas realizadas: {$registro->getCantidadVentas()}\n";
echo 'Monto total: Bs ' . number_format($registro->getMontoAcumulado(), 2) . "\n";
echo 'Stock restante de Pringles: ' . $inventario->getStock('SKU-004') . " unidades\n";

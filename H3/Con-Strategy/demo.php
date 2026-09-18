<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/EstrategiaDescuento.php';
require_once __DIR__ . '/SinDescuento.php';
require_once __DIR__ . '/DescuentoPorMonto.php';
require_once __DIR__ . '/DescuentoPorMayoreo.php';
require_once __DIR__ . '/SelectorEstrategiaDescuento.php';
require_once __DIR__ . '/Venta.php';

use App\ConStrategy\Usuario;
use App\ConStrategy\Producto;
use App\ConStrategy\ItemVenta;
use App\ConStrategy\Venta;
use App\ConStrategy\SelectorEstrategiaDescuento;

function mostrarResultado(Venta $venta): void
{
    $estrategia = SelectorEstrategiaDescuento::elegir($venta);
    $venta->aplicarEstrategiaDescuento($estrategia);

    echo "--- Venta #{$venta->getIdVenta()} ---\n";
    echo 'Estrategia elegida por el sistema: ' . $estrategia::class . "\n";
    echo 'Subtotal: Bs ' . number_format($venta->calcularTotal(), 2) . "\n";
    echo 'Descuento aplicado: Bs ' . number_format($venta->getDescuentoAplicado(), 2) . "\n";
    echo 'TOTAL A PAGAR: Bs ' . number_format($venta->calcularTotalConDescuento(), 2) . "\n\n";
}

// ---------- Catalogo ----------
$cholike  = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 6.50);
$marilan  = new Producto(idProducto: 2, sku: 'SKU-002', nombre: 'Galletas Marilan', precio: 12.00);
$pringles = new Producto(idProducto: 3, sku: 'SKU-004', nombre: 'Papas Pringles', precio: 25.00);
$cobBlanco = new Producto(idProducto: 4, sku: 'SKU-005', nombre: 'Cobertura chocolate blanco 1kg', precio: 55.00);

$cliente = new Usuario(idUsuario: 1, nombre: 'Maria Quispe', email: 'maria@example.com');

// ===== VENTA 1: compra chica, no califica para nada =====
$venta1 = new Venta(idVenta: 1, usuario: $cliente, fecha: new \DateTimeImmutable('now'));
$venta1->agregarItem(new ItemVenta(idItem: 1, producto: $cholike, cantidad: 2));
mostrarResultado($venta1); // Esperado: SinDescuento

// ===== VENTA 2: monto alto (2 coberturas), pocas unidades =====
$venta2 = new Venta(idVenta: 2, usuario: $cliente, fecha: new \DateTimeImmutable('now'));
$venta2->agregarItem(new ItemVenta(idItem: 1, producto: $cobBlanco, cantidad: 4)); // Bs 220
mostrarResultado($venta2); // Esperado: DescuentoPorMonto

// ===== VENTA 3: muchas unidades (perfil reventa) =====
$venta3 = new Venta(idVenta: 3, usuario: $cliente, fecha: new \DateTimeImmutable('now'));
$venta3->agregarItem(new ItemVenta(idItem: 1, producto: $cholike, cantidad: 15));
$venta3->agregarItem(new ItemVenta(idItem: 2, producto: $marilan, cantidad: 10));
mostrarResultado($venta3); // Esperado: DescuentoPorMayoreo

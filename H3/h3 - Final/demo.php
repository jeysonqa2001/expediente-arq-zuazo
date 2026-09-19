<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/ProcesadorPago.php';
require_once __DIR__ . '/PasarelaPagoExternaSDK.php';
require_once __DIR__ . '/AdaptadorPasarelaTarjeta.php';
require_once __DIR__ . '/ObservadorVenta.php';
require_once __DIR__ . '/Venta.php';
require_once __DIR__ . '/NotificadorCliente.php';
require_once __DIR__ . '/ControlInventario.php';

use App\ConFinal\Usuario;
use App\ConFinal\Producto;
use App\ConFinal\ItemVenta;
use App\ConFinal\Venta;
use App\ConFinal\AdaptadorPasarelaTarjeta;
use App\ConFinal\NotificadorCliente;
use App\ConFinal\ControlInventario;

// ---------- Catalogo ----------
$cholike = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 6.50);
$marilan = new Producto(idProducto: 2, sku: 'SKU-002', nombre: 'Galletas Marilan', precio: 12.00);
$pringles = new Producto(idProducto: 3, sku: 'SKU-004', nombre: 'Papas Pringles', precio: 25.00);

// ---------- Observadores (compartidos entre ambas ventas) ----------
$notificador = new NotificadorCliente();
$inventario = new ControlInventario([
    'SKU-001' => 40,
    'SKU-002' => 25,
    'SKU-004' => 8,
]);

// ================= VENTA 1: pago APROBADO =================
echo "========== VENTA #1 (tarjeta valida) ==========\n";

$adaptadorValido = new AdaptadorPasarelaTarjeta(cardToken: 'tok_visa_1234');

$venta1 = new Venta(
    idVenta: 1,
    usuario: new Usuario(1, 'Maria Quispe', 'maria@example.com'),
    fecha: new \DateTimeImmutable('now'),
    procesador: $adaptadorValido
);

$venta1->suscribir($notificador);
$venta1->suscribir($inventario);

$venta1->agregarItem(new ItemVenta(idItem: 1, producto: $cholike, cantidad: 3));
$venta1->agregarItem(new ItemVenta(idItem: 2, producto: $pringles, cantidad: 4));

$resultado1 = $venta1->confirmar();
echo 'Venta #1 confirmada: ' . ($resultado1 ? 'SI' : 'NO') . "\n\n";

// ================= VENTA 2: pago RECHAZADO =================
echo "========== VENTA #2 (tarjeta rechazada) ==========\n";

$adaptadorRechazado = new AdaptadorPasarelaTarjeta(cardToken: 'tok_declined_9999');

$venta2 = new Venta(
    idVenta: 2,
    usuario: new Usuario(2, 'Carlos Mamani', 'carlos@example.com'),
    fecha: new \DateTimeImmutable('now'),
    procesador: $adaptadorRechazado
);

$venta2->suscribir($notificador);
$venta2->suscribir($inventario);

$venta2->agregarItem(new ItemVenta(idItem: 1, producto: $marilan, cantidad: 5));

$resultado2 = $venta2->confirmar();
echo 'Venta #2 confirmada: ' . ($resultado2 ? 'SI' : 'NO') . "\n\n";

// ================= Verificacion final =================
echo "========== VERIFICACION ==========\n";
echo 'Stock de Marilan (SKU-002) despues de ambas ventas: ' . $inventario->getStock('SKU-002') . " unidades\n";
echo "(Deberia seguir en 25 -- la venta #2 nunca descuento stock porque el pago fue rechazado)\n";

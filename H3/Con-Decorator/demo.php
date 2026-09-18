<?php

declare(strict_types=1);

require_once __DIR__ . '/Usuario.php';
require_once __DIR__ . '/Producto.php';
require_once __DIR__ . '/ItemVenta.php';
require_once __DIR__ . '/Venta.php';
require_once __DIR__ . '/Comprobante.php';
require_once __DIR__ . '/ComprobanteBase.php';
require_once __DIR__ . '/ComprobanteDecorator.php';
require_once __DIR__ . '/ConDescuentoDetallado.php';
require_once __DIR__ . '/ConMensajePromocional.php';

use App\ConDecorator\Usuario;
use App\ConDecorator\Producto;
use App\ConDecorator\ItemVenta;
use App\ConDecorator\Venta;
use App\ConDecorator\ComprobanteBase;
use App\ConDecorator\ConDescuentoDetallado;
use App\ConDecorator\ConMensajePromocional;

$cholike = new Producto(idProducto: 1, sku: 'SKU-001', nombre: 'Cholike', precio: 6.50);
$cobBlanco = new Producto(idProducto: 2, sku: 'SKU-005', nombre: 'Cobertura chocolate blanco 1kg', precio: 55.00);

$venta1 = new Venta(idVenta: 1, usuario: new Usuario(1, 'Maria Quispe', 'maria@example.com'), fecha: new \DateTimeImmutable('now'));
$venta1->agregarItem(new ItemVenta(idItem: 1, producto: $cobBlanco, cantidad: 4)); // Bs 220
$venta1->setDescuento(22.0); // 10% ya calculado (podria venir de con-strategy)

echo ">>> COMBINACION 1: ComprobanteBase + ConDescuentoDetallado\n";
$comprobante1 = new ConDescuentoDetallado(new ComprobanteBase());
echo $comprobante1->generar($venta1);
echo "\n";

$venta2 = new Venta(idVenta: 2, usuario: new Usuario(2, 'Carlos Mamani', 'carlos@example.com'), fecha: new \DateTimeImmutable('now'));
$venta2->agregarItem(new ItemVenta(idItem: 1, producto: $cholike, cantidad: 3));
$venta2->setDescuento(1.95); // descuento chico, para que se note que la capa 1 tambien esta activa aqui

echo ">>> COMBINACION 2: ComprobanteBase + ConDescuentoDetallado + ConMensajePromocional\n";
$comprobante2 = new ConMensajePromocional(new ConDescuentoDetallado(new ComprobanteBase()));
echo $comprobante2->generar($venta2);

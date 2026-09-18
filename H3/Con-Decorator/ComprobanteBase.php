<?php

declare(strict_types=1);

namespace App\ConDecorator;

final class ComprobanteBase implements Comprobante
{
    public function generar(Venta $venta): string
    {
        $texto = "===== COMPROBANTE DE VENTA =====\n";
        $texto .= "Venta #{$venta->getIdVenta()} - Cliente: {$venta->getUsuario()->getNombre()}\n";
        $texto .= "Fecha: {$venta->getFecha()->format('Y-m-d H:i')}\n";
        $texto .= "---------------------------------\n";

        foreach ($venta->getItems() as $item) {
            $nombre = $item->getProducto()->getNombre();
            $cantidad = $item->getCantidad();
            $subtotal = number_format($item->calcularSubtotal(), 2);
            $texto .= "{$nombre} x{$cantidad} ..... Bs {$subtotal}\n";
        }

        $texto .= "---------------------------------\n";
        $texto .= 'TOTAL: Bs ' . number_format($venta->calcularTotalConDescuento(), 2) . "\n";

        return $texto;
    }
}

<?php

declare(strict_types=1);

namespace App\ConDecorator;

final class ConDescuentoDetallado extends ComprobanteDecorator
{
    public function generar(Venta $venta): string
    {
        $texto = $this->envuelto->generar($venta); // primero, lo que ya traia

        if ($venta->getDescuento() > 0.0) {
            $texto .= "---------------------------------\n";
            $texto .= 'Subtotal: Bs ' . number_format($venta->calcularTotal(), 2) . "\n";
            $texto .= 'Descuento aplicado: -Bs ' . number_format($venta->getDescuento(), 2) . "\n";
        }

        return $texto;
    }
}

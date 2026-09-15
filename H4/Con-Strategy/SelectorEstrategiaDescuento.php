<?php

declare(strict_types=1);

namespace App\ConStrategy;

final class SelectorEstrategiaDescuento
{
    public static function elegir(Venta $venta): EstrategiaDescuento
    {
        $porMayoreo = new DescuentoPorMayoreo();
        $porMonto = new DescuentoPorMonto();

        if ($porMayoreo->calcularDescuento($venta) > 0.0) {
            return $porMayoreo;
        }

        if ($porMonto->calcularDescuento($venta) > 0.0) {
            return $porMonto;
        }

        return new SinDescuento();
    }
}

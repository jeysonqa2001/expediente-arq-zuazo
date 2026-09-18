<?php

declare(strict_types=1);

namespace App\ConStrategy;

final class DescuentoPorMayoreo implements EstrategiaDescuento
{
    private const UMBRAL_UNIDADES = 20;
    private const PORCENTAJE_DESCUENTO = 0.15; // 15%

    public function calcularDescuento(Venta $venta): float
    {
        $unidadesTotales = 0;
        foreach ($venta->getItems() as $item) {
            $unidadesTotales += $item->getCantidad();
        }

        if ($unidadesTotales < self::UMBRAL_UNIDADES) {
            return 0.0;
        }

        return $venta->calcularTotal() * self::PORCENTAJE_DESCUENTO;
    }
}

<?php

declare(strict_types=1);

namespace App\ConDecorator;

final class ConMensajePromocional extends ComprobanteDecorator
{
    public function generar(Venta $venta): string
    {
        $texto = $this->envuelto->generar($venta);
        $texto .= "=================================\n";
        $texto .= "Gracias por tu compra. Vuelve pronto,\n";
        $texto .= "presenta este ticket y llevate un 5% en tu proxima visita.\n";

        return $texto;
    }
}

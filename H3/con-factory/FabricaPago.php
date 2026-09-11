<?php

declare(strict_types=1);

namespace App\ConFactory;

final class FabricaPago
{
    /** @var array<string, class-string<ProcesadorPago>> */
    private static array $tipos = [
        'efectivo' => PagoEfectivo::class,
        'transferencia' => PagoTransferencia::class,
        'tarjeta' => PagoTarjeta::class,
    ];

    public static function crear(string $tipoPago): ProcesadorPago
    {
        $clave = strtolower(trim($tipoPago));

        if (!isset(self::$tipos[$clave])) {
            $opciones = implode(', ', array_keys(self::$tipos));
            throw new \InvalidArgumentException(
                "Tipo de pago '{$tipoPago}' no soportado. Opciones validas: {$opciones}"
            );
        }

        $clase = self::$tipos[$clave];
        return new $clase();
    }
}

<?php

declare(strict_types=1);

namespace App\ConFactory;

interface ProcesadorPago
{
    public function procesar(float $monto): bool;
}

final class PagoEfectivo implements ProcesadorPago
{
    public function procesar(float $monto): bool
    {
        echo "[Efectivo] Cobrando Bs " . number_format($monto, 2) . " en caja...\n";
        return true;
    }
}

final class PagoTransferencia implements ProcesadorPago
{
    public function procesar(float $monto): bool
    {
        echo "[Transferencia] Verificando comprobante por Bs " . number_format($monto, 2) . "...\n";
        return true;
    }
}

final class PagoTarjeta implements ProcesadorPago
{
    public function procesar(float $monto): bool
    {
        echo "[Tarjeta] Autorizando cobro con pasarela por Bs " . number_format($monto, 2) . "...\n";
        return true;
    }
}

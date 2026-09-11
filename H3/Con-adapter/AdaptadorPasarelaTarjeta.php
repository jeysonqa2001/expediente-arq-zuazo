<?php

declare(strict_types=1);

namespace App\ConAdapter;

final class AdaptadorPasarelaTarjeta implements ProcesadorPago
{
    private readonly PasarelaPagoExternaSDK $sdkExterno;

    public function __construct(private readonly string $cardToken)
    {
        $this->sdkExterno = new PasarelaPagoExternaSDK();
    }

    public function procesar(float $monto): bool
    {
        $montoEnCentavos = (int) round($monto * 100);

        $respuesta = $this->sdkExterno->chargeAmount($montoEnCentavos, $this->cardToken);

        return $respuesta['status'] === 'APPROVED';
    }
}

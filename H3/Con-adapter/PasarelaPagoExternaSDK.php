<?php

declare(strict_types=1);

namespace App\ConAdapter;

final class PasarelaPagoExternaSDK
{
    /** @return array{status: string, transactionId: string} */
    public function chargeAmount(int $amountCents, string $cardToken): array
    {
        echo "   (SDK externo) Cobrando {$amountCents} centavos al token '{$cardToken}'...\n";

        $aprobado = $amountCents > 0;

        return [
            'status' => $aprobado ? 'APPROVED' : 'DECLINED',
            'transactionId' => 'TXN-' . random_int(10000, 99999),
        ];
    }
}

<?php

declare(strict_types=1);

namespace App\ConFinal;

final class NotificadorCliente implements ObservadorVenta
{
    public function alConfirmarVenta(Venta $venta): void
    {
        $email = $venta->getUsuario()->getEmail();
        $nombre = $venta->getUsuario()->getNombre();
        $total = number_format($venta->calcularTotal(), 2);

        echo "[NotificadorCliente] Enviando comprobante a {$email}\n";
        echo "   Hola {$nombre}, tu pago fue aprobado. Detalle de tu compra:\n";

        foreach ($venta->getItems() as $item) {
            $producto = $item->getProducto()->getNombre();
            $cantidad = $item->getCantidad();
            $subtotal = number_format($item->calcularSubtotal(), 2);
            echo "     - {$producto} x{$cantidad} = Bs {$subtotal}\n";
        }

        echo "   Total pagado: Bs {$total}\n";
    }
}

<?php

declare(strict_types=1);

namespace App\ConObserver;

final class NotificadorCliente implements ObservadorVenta
{
    public function alConfirmarVenta(Venta $venta): void
    {
        $email = $venta->getUsuario()->getEmail();
        $nombre = $venta->getUsuario()->getNombre();
        $total = number_format($venta->calcularTotal(), 2);

        echo "[NotificadorCliente] Enviando comprobante a {$email}\n";
        echo "   Hola {$nombre}, gracias por tu compra en la tienda.\n";
        echo "   Detalle de tu pedido #{$venta->getIdVenta()}:\n";

        foreach ($venta->getItems() as $item) {
            $producto = $item->getProducto()->getNombre();
            $cantidad = $item->getCantidad();
            $subtotal = number_format($item->calcularSubtotal(), 2);
            echo "     - {$producto} x{$cantidad} = Bs {$subtotal}\n";
        }

        echo "   Total pagado: Bs {$total}\n";
    }
}

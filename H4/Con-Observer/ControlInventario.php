<?php

declare(strict_types=1);

namespace App\ConObserver;

final class ControlInventario implements ObservadorVenta
{
    private const STOCK_MINIMO = 5;

    /** @var array<string, int> stock actual indexado por SKU */
    private array $stockPorSku;

    /** @param array<string, int> $stockInicial */
    public function __construct(array $stockInicial)
    {
        $this->stockPorSku = $stockInicial;
    }

    public function alConfirmarVenta(Venta $venta): void
    {
        echo "[ControlInventario] Descontando stock de la venta #{$venta->getIdVenta()}\n";

        foreach ($venta->getItems() as $item) {
            $sku = $item->getProducto()->getSku();
            $nombre = $item->getProducto()->getNombre();
            $cantidad = $item->getCantidad();

            if (!isset($this->stockPorSku[$sku])) {
                echo "   AVISO: {$nombre} ({$sku}) no estaba registrado en inventario.\n";
                continue;
            }

            $this->stockPorSku[$sku] -= $cantidad;
            $restante = $this->stockPorSku[$sku];

            echo "   {$nombre}: -{$cantidad} unidades -> quedan {$restante}\n";

            if ($restante <= self::STOCK_MINIMO) {
                echo "   ALERTA: stock bajo de {$nombre} (quedan {$restante}). Reponer.\n";
            }
        }
    }

    public function getStock(string $sku): int
    {
        return $this->stockPorSku[$sku] ?? 0;
    }
}

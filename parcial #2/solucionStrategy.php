<?php

interface EstrategiaMulta {
    public function calcularMulta(int $diasAtraso): float;
}

class MultaInfantil implements EstrategiaMulta {
    public function calcularMulta(int $diasAtraso): float {
        return 0.0;
    }
}

class MultaAdulto implements EstrategiaMulta {
    public function calcularMulta(int $diasAtraso): float {
        return $diasAtraso * 2.0;
    }
}

class MultaTerceraEdad implements EstrategiaMulta {
    public function calcularMulta(int $diasAtraso): float {
        $total = $diasAtraso * 1.0;
        return min($total, 20.0);
    }
}

class CalculadoraMulta {
    private EstrategiaMulta $estrategia;

    public function __construct(EstrategiaMulta $estrategia) {
        $this->estrategia = $estrategia;
    }

    public function establecerEstrategia(EstrategiaMulta $estrategia): void {
        $this->estrategia = $estrategia;
    }

    public function obtenerMontoFinal(int $diasAtraso): float {
        return $this->estrategia->calcularMulta($diasAtraso);
    }
}

$diasDeAtraso = 10;

$calculadora = new CalculadoraMulta(new MultaInfantil());
echo "Multa Socio Infantil (10 dias): " . $calculadora->obtenerMontoFinal($diasDeAtraso) . " Bs\n";

$calculadora->establecerEstrategia(new MultaAdulto());
echo "Multa Socio Adulto (10 dias): " . $calculadora->obtenerMontoFinal($diasDeAtraso) . " Bs\n";

$calculadora->establecerEstrategia(new MultaTerceraEdad());
echo "Multa Socio Tercera Edad (25 dias): " . $calculadora->obtenerMontoFinal(25) . " Bs\n";
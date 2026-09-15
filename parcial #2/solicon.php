<?php

interface ObservadorPrestamo {
    public function actualizar(int $idPrestamo): void;
}

class ModuloPrestamos {
    private array $observadores = [];

    public function registrarObservador(ObservadorPrestamo $observador): void {
        $this->observadores[] = $observador;
    }

    public function notificar(int $idPrestamo): void {
        foreach ($this->observadores as $observador) {
            $observador->actualizar($idPrestamo);
        }
    }

    public function vencerPrestamo(int $idPrestamo): void {
        $this->notificar($idPrestamo);
    }
}

// Suscriptores Concretos
class NotificacionCorreo implements ObservadorPrestamo {
    public function actualizar(int $idPrestamo): void {
        echo "[Correo] Enviando email por préstamo vencido #{$idPrestamo}\n";
    }
}

class RegistroMorosidad implements ObservadorPrestamo {
    public function actualizar(int $idPrestamo): void {
        echo "[Morosidad] Registrando préstamo #{$idPrestamo} en lista negra\n";
    }
}

class PantallaRecepcion implements ObservadorPrestamo {
    public function actualizar(int $idPrestamo): void {
        echo "[Pantalla] Alerta visual desplegada para préstamo #{$idPrestamo}\n";
    }
}

class SistemaMultasMunicipal implements ObservadorPrestamo {
    public function actualizar(int $idPrestamo): void {
        echo "[Multas Municipal] Reportando sanción de préstamo #{$idPrestamo}\n";
    }
}
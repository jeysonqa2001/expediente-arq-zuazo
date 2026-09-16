<?php

class ServicioEstatalApi {
    public function PushRecord(string $jsonPayload, string $isoDate, string $originCode): void {
        echo "[API Estatal Externa] Registro exitoso:\n";
        echo " - Payload: {$jsonPayload}\n";
        echo " - Fecha ISO: {$isoDate}\n";
        echo " - Origen: {$originCode}\n";
    }
}

interface CatalogoEstatalTarget {
    public function registrarLibro(int $idLibro, string $titulo, string $fechaPublicacion): void;
}

class ServicioEstatalAdapter implements CatalogoEstatalTarget {
    private ServicioEstatalApi $apiExterna;

    public function __construct(ServicioEstatalApi $apiExterna) {
        $this->apiExterna = $apiExterna;
    }

    public function registrarLibro(int $idLibro, string $titulo, string $fechaPublicacion): void {
        $payload = json_encode([
            "id" => $idLibro,
            "title" => $titulo
        ]);
        
        $isoDate = date("c", strtotime($fechaPublicacion));
        $originCode = "BIB-MUNI-LOCAL";

        $this->apiExterna->PushRecord($payload, $isoDate, $originCode);
    }
}

$apiExterna = new ServicioEstatalApi();
$adaptadorCatalogo = new ServicioEstatalAdapter($apiExterna);

$adaptadorCatalogo->registrarLibro(1045, "Cien Años de Soledad", "2026-09-15");
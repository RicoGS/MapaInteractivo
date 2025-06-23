<?php
require_once(__DIR__ . '/conection.php');


class DeleteContact {
    private $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    public function deleteContact($nombre) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM data_general WHERE NOMBRE = :nombre");
            $stmt->bindParam(":nombre", $nombre);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Contacto eliminado correctamente'];
            } else {
                return ['success' => false, 'message' => 'No se encontró el contacto'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al eliminar contacto'];
        }
    }
}

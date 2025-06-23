<?php
require_once __DIR__ . '/conection.php';
class FormsModel {
    static public function getUserByUsername($username) {
        try {
            $db = (new Conexion())->conectar();
            $stmt = $db->prepare("SELECT idUser, username, password, rol FROM usuario WHERE username = :username");
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el usuario o false
        } catch (PDOException $e) {
            error_log("Error en getUserByUsername: " . $e->getMessage());
            return false; // En caso de error, devuelve false
        }
    }
        static public function getUserByData($nombre) {
        try {
            $db = (new Conexion())->conectar();
            $stmt = $db->prepare("SELECT ID, NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO, DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID FROM data_general WHERE NOMBRE = :Nombre");
            $stmt->bindParam(':Nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el nombre o false
        } catch (PDOException $e) {
            error_log("Error en getUserByUsername: " . $e->getMessage());
            return false; // En caso de error, devuelve false
        }
    }

    static public function getDataByMunicipio($municipio) {
    try {
        $db = (new Conexion())->conectar();
        $stmt = $db->prepare("SELECT * FROM data_general WHERE MUNICIPIO = :municipio");
        $stmt->bindParam(':municipio', $municipio, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en getDataByMunicipio: " . $e->getMessage());
        return [];
    }
    }

    static public function buscarContactos($termino) {
        try {
            $db = (new Conexion())->conectar();
            $sql = "SELECT ID, NOMBRE, MUNICIPIO, OCUPACION 
                    FROM data_general 
                    WHERE NOMBRE LIKE :term 
                    OR MUNICIPIO LIKE :term 
                    OR OCUPACION LIKE :term 
                    LIMIT 20";
            $stmt = $db->prepare($sql);
            $searchTerm = "%{$termino}%";
            $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            $results = [];
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $results[] = [
                    'id' => $row['ID'],
                    'text' => "{$row['NOMBRE']} - {$row['MUNICIPIO']} - {$row['OCUPACION']}"
                ];
            }

            return $results;
        } catch (PDOException $e) {
            error_log("Error en buscarContactos: " . $e->getMessage());
            return [];
        }
    }
    static public function getContactoById($id) {
    try {
        $db = (new Conexion())->conectar();
        $stmt = $db->prepare("SELECT NOMBRE, TELEFONO, MUNICIPIO, OCUPACION, CLASIFICACIONID FROM data_general WHERE ID = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en getContactoById: " . $e->getMessage());
        return false;
    }
    }
    static public function eliminarContactoPorId($id) {
    try {
        $db = (new Conexion())->conectar();

        // Obtener datos antes de eliminar
        $stmt = $db->prepare("SELECT * FROM data_general WHERE ID = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $contacto = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$contacto) {
            return ['success' => false, 'message' => 'Contacto no encontrado'];
        }

        // Eliminar el contacto
        $deleteStmt = $db->prepare("DELETE FROM data_general WHERE ID = :id");
        $deleteStmt->bindParam(':id', $id, PDO::PARAM_INT);
        $deleteStmt->execute();

        if ($deleteStmt->rowCount() > 0) {
            // Registrar en log CSV
            $logPath = __DIR__ . '/../logs/log_eliminaciones.csv';
            $fecha = date('Y-m-d H:i:s');
            $ip = $_SERVER['REMOTE_ADDR'] ?? 'IP_desconocida';

            $linea = [
                $fecha,
                $ip,
                $contacto['ID'],
                $contacto['NOMBRE'],
                $contacto['TELEFONO'],
                $contacto['MUNICIPIO'],
                $contacto['OCUPACION'],
                $contacto['CLASIFICACIONID']
            ];

            $fileExists = file_exists($logPath);
            $fp = fopen($logPath, 'a');
            if (!$fileExists) {
                // Escribir encabezado si el archivo no existe
                fputcsv($fp, ['FECHA', 'IP', 'ID', 'NOMBRE', 'TELEFONO', 'MUNICIPIO', 'OCUPACION', 'CLASIFICACIONID']);
            }
            fputcsv($fp, $linea);
            fclose($fp);

            return ['success' => true, 'message' => 'Contacto eliminado y registrado en log'];
        } else {
            return ['success' => false, 'message' => 'No se pudo eliminar el contacto'];
        }

    } catch (PDOException $e) {
        error_log("Error en eliminarContactoPorId: " . $e->getMessage());
        return ['success' => false, 'message' => 'Error al eliminar contacto'];
    }
    }
    
}



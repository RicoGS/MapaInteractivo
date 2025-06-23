<?php
require_once __DIR__ . '/conection.php';

class ManagementContact {

    private $conn;
    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }
    public function getContactByData($nombre) {
        try {
            $stmt = $this->conn->prepare("SELECT ID, NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO, DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID FROM data_general WHERE NOMBRE = :nombre");
            $stmt->bindParam(':nombre', $nombre, PDO::PARAM_STR);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC); // Devuelve el nombre o false
        } catch (PDOException $e) {
            error_log("Error en getContactByData: " . $e->getMessage());
            return false; // En caso de error, devuelve false
        }
    }
    public function addContact($data) {
        try {
            // Validar que todos los campos requeridos existan
            $requiredFields = ['name', 'phone', 'municipio', 'persona', 'domicilio', 'distrito', 'redes', 'ocupacion', 'seccion', 'clasificacion'];
            foreach ($requiredFields as $field) {
                if (!isset($data[$field]) || trim($data[$field]) === '') {
                    return ['success' => false, 'message' => "El campo '$field' es obligatorio"];
                }
            }

            // Sanitizar datos
            $sanitizedData = array_map(function($value) {
                return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }, $data);

            // Verificar si el teléfono ya está registrado
            $checkStmt = $this->conn->prepare("SELECT ID FROM data_general WHERE TELEFONO = :phone");
            $checkStmt->bindParam(":phone", $sanitizedData['phone']);
            $checkStmt->execute();
            $result = $checkStmt->fetch();

            if ($result) {
                return ['success' => false, 'message' => 'El teléfono ya está registrado'];
            }

            // Preparar inserción
            $stmt = $this->conn->prepare("INSERT INTO data_general 
                (NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO, DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID) 
                VALUES 
                (:name, :phone, :municipio, :persona, :domicilio, :distrito, :redes, :ocupacion, :seccion, :clasificacion)");

            // Asignar valores
            $stmt->bindParam(":name", $sanitizedData['name']);
            $stmt->bindParam(":phone", $sanitizedData['phone']);
            $stmt->bindParam(":municipio", $sanitizedData['municipio']);
            $stmt->bindParam(":persona", $sanitizedData['persona']);
            $stmt->bindParam(":domicilio", $sanitizedData['domicilio']);
            $stmt->bindParam(":distrito", $sanitizedData['distrito']);
            $stmt->bindParam(":redes", $sanitizedData['redes']);
            $stmt->bindParam(":ocupacion", $sanitizedData['ocupacion']);
            $stmt->bindParam(":seccion", $sanitizedData['seccion']);
            $stmt->bindParam(":clasificacion", $sanitizedData['clasificacion']);

            $stmt->execute();

            return ['success' => true, 'message' => 'Contacto agregado correctamente'];
        } catch (PDOException $e) {
            error_log("Error al insertar contacto: " . $e->getMessage());
            return ['success' => false, 'message' => 'Error interno al agregar contacto'];
        }
    }
    public function deleteContactbyId($id) {
        try {
            // Obtener datos antes de eliminar
            $stmt = $this->conn->prepare("SELECT * FROM data_general WHERE ID = :id");
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $contacto = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$contacto) {
                return ['success' => false, 'message' => 'Contacto no encontrado'];
            }
            // Eliminar el contacto
            $deleteStmt = $this->conn->prepare("DELETE FROM data_general WHERE ID = :id");
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
    public function buscarContact($termino) {
        $results = [];
        try {
            // Prepara el término de búsqueda
            $searchTerm = "%{$termino}%";
            $stmt = $this->conn->prepare("SELECT ID, NOMBRE, MUNICIPIO, OCUPACION 
                    FROM data_general 
                    WHERE NOMBRE LIKE :term 
                    OR MUNICIPIO LIKE :term 
                    OR OCUPACION LIKE :term 
                    LIMIT 20");
            $stmt->bindParam(':term', $searchTerm, PDO::PARAM_STR);
            $stmt->execute();
            foreach ($stmt->fetchAll(PDO::FETCH_ASSOC) as $row) {
                $results[] = [
                    'id' => $row['ID'],
                    'text' => "{$row['NOMBRE']} - {$row['MUNICIPIO']} - {$row['OCUPACION']}"
                ];
            }
        }
        catch (PDOException $e) {
            error_log("Error en buscarContactos: " . $e->getMessage());
            return [];
        }
        return $results;
    }
    public function getContactoById($id) {
    try {
        $stmt = $this->conn->prepare("SELECT NOMBRE, TELEFONO, MUNICIPIO, OCUPACION, CLASIFICACIONID FROM data_general WHERE ID = :id");
        $stmt->bindParam(":id", $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error en getContactoById: " . $e->getMessage());
        return false;
    }
    }
    public function filtrarContactos($distrito, $clasificacion) {
        $sql = "SELECT * FROM data_general WHERE 1=1";
        $params = [];
        if ($distrito !== 'All') {
            $sql .= " AND DISTRITO = :distrito";
            $params[':distrito'] = $distrito;
        }
        if ($clasificacion !== 'All') {
            $sql .= " AND CLASIFICACIONID = :clasificacion";
            $params[':clasificacion'] = $clasificacion;
        }
        $stmt = $this->conn->prepare($sql);
        foreach ($params as $key => $value) {
            $stmt->bindValue($key, $value, PDO::PARAM_STR);
        }
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
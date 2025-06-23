<?php
require_once(__DIR__ . '/conection.php');

class CsvModel {
    private $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
    }

    public function processCsv($filePath, $fileName) {
    if (!file_exists($filePath) || !is_readable($filePath)) {
        return ['success' => false, 'message' => 'Error al abrir el archivo'];
    }

    $inserted = 0;
    $handle = fopen($filePath, "r");
    fgetcsv($handle); // Saltar encabezado

    $stmt = $this->conn->prepare("INSERT INTO data_general 
        (NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO, DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID) 
        VALUES 
        (:name, :phone, :municipio, :persona, :domicilio, :distrito, :redes, :ocupacion, :seccion, :clasificacion)");

    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        if (count($data) < 11) continue;

        $sanitizedData = array_map(fn($value) => htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8'), $data);
        list(, $name, $phone, $municipio, $persona, $domicilio, $distrito, $redes, $ocupacion, $seccion, $clasificacion) = $sanitizedData;

        $checkStmt = $this->conn->prepare("SELECT ID FROM data_general WHERE TELEFONO = :phone");
        $checkStmt->bindValue(":phone", $phone);
        $checkStmt->execute();

        if (!$checkStmt->fetch()) {
            $stmt->bindValue(":name", $name);
            $stmt->bindValue(":phone", $phone);
            $stmt->bindValue(":municipio", $municipio);
            $stmt->bindValue(":persona", $persona);
            $stmt->bindValue(":domicilio", $domicilio);
            $stmt->bindValue(":distrito", $distrito);
            $stmt->bindValue(":redes", $redes);
            $stmt->bindValue(":ocupacion", $ocupacion);
            $stmt->bindValue(":seccion", $seccion);
            $stmt->bindValue(":clasificacion", $clasificacion);
            $stmt->execute();
            $inserted++;
        }
    }

    fclose($handle);
    file_put_contents("logs.csv", date("Y-m-d H:i:s") . ", Archivo cargado: " . basename($fileName) . ", Registros insertados: $inserted" . PHP_EOL, FILE_APPEND);

    return [
        'success' => $inserted > 0,
        'message' => $inserted > 0 
            ? "Se insertaron $inserted registros correctamente" 
            : "No se insertó ningún registro (posiblemente duplicados)"
    ];
}

}
class DeleteContact{
    private $conn;
    public function __construct() {
        $this->conn = (new Conexion())->conectar(); // Usa tu conexión existente
    }
    public function deleteContact($id) {
        try {
            $stmt = $this->conn->prepare("DELETE FROM data_general WHERE NOMBRE = :nombre");
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                return ['success' => true, 'message' => 'Contacto eliminado correctamente'];
            } else {
                return ['success' => false, 'message' => 'No se encontró el contacto'];
            }
        } catch (PDOException $e) {
            return ['success' => false, 'message' => 'Error al eliminar contacto'];
        }
    }}
class AddContact{
    private $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar(); // Usa tu conexión existente
    }
    public function addContact($data) {
        try {
            // Sanitizar entrada
            $sanitizedData = array_map(function($value) {
                return htmlspecialchars(trim($value), ENT_QUOTES, 'UTF-8');
            }, $data);
            // Verificar si el teléfono ya existe
            $checkStmt = $this->conn->prepare("SELECT ID FROM data_general WHERE TELEFONO = :phone");
            $checkStmt->bindParam(":phone", $sanitizedData['phone']);
            $checkStmt->execute();
            $result = $checkStmt->fetch();

            if ($result) {
                return ['success' => false, 'message' => 'El teléfono ya está registrado'];
            }
            // Insertar contacto
            $stmt = $this->conn->prepare("INSERT INTO data_general 
                (NOMBRE, TELEFONO, MUNICIPIO, PERSONACONTACTO, DOMICILIO, DISTRITO, REDESSOCIALES, OCUPACION, SECCIONELECTORAL, CLASIFICACIONID) 
                VALUES 
                (:name, :phone, :municipio, :persona, :domicilio, :distrito, :redes, :ocupacion, :seccion, :clasificacion)");

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
            return ['success' => false, 'message' => 'Error al agregar contacto: ' . $e->getMessage()];
        }
    }
    }
?>
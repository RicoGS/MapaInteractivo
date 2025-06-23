<?php
require_once(__DIR__ . '/conection.php');

class AddContact {
    private $conn;

    public function __construct() {
        $this->conn = (new Conexion())->conectar();
        $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Asegura que se lancen excepciones
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
}
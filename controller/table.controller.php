<?php
require_once __DIR__ . '/../model/forms.models.php';

header('Content-Type: application/json');

try {
    $conn = (new Conexion())->conectar();

    // Consulta con JOIN para traer el nombre de la clasificación
    $stmt = $conn->prepare("
        SELECT 
            data_general.NOMBRE,
            data_general.DOMICILIO,
            data_general.TELEFONO,
            data_general.OCUPACION,
            data_general.PERSONACONTACTO,
            data_general.MUNICIPIO,
            data_general.DISTRITO,
            clasificacion.NOMBRE AS clasificacion,
            data_general.SECCIONELECTORAL,
            data_general.REDESSOCIALES
        FROM data_general
        JOIN clasificacion ON data_general.CLASIFICACIONID = clasificacion.ID
    ");
    $stmt->execute();
    $resultado = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($resultado);
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error en la base de datos: ' . $e->getMessage()]);
}

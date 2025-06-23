<?php
require_once __DIR__ . '/../model/conection.php'; // ajusta el path a tu conexión

$municipio = $_GET['municipio'] ?? '';

if (!$municipio) {
  echo json_encode(['total' => 0]);
  exit;
}

$conn = (new Conexion())->conectar();

$sql = "SELECT COUNT(*) AS total FROM contactos WHERE municipio = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $municipio);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();

echo json_encode(['total' => $row['total'] ?? 0]);

<?php
require_once __DIR__ . '/../model/Contact.models.php';

// Leer datos del POST
$data = json_decode(file_get_contents('php://input'), true);
$id = $data['id'] ?? null;

if ($id && is_numeric($id)) {
    $contactManager = new ManagementContact();
    $resultado = $contactManager->deleteContactbyId((int)$id);
    echo json_encode($resultado);
} else {
    echo json_encode(['success' => false, 'message' => 'ID no válido o no recibido']);
}

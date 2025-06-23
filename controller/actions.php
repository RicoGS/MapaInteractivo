<?php
header('Content-Type: application/json');
require_once 'forms.controller.php';

// Verificar que la solicitud sea POST
if (!isset($_SERVER['REQUEST_METHOD']) || $_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método de solicitud incorrecto']);
    exit;
}

$username = $_POST['username'] ?? '';
$password = $_POST['password'] ?? '';

$response = FormsController::login($username, $password);

// Solo se maneja una sesión dentro de login()
if ($response['success']) {
    echo json_encode(['success' => true, 'redirect' => 'view/pages/Inicio.php']);
} else {
    echo json_encode(['success' => false, 'message' => $response['message']]);
}
exit;

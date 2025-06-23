<?php
header('Content-Type: application/json');
require_once(__DIR__ . '/../model/CsvModel.php');
require_once(__DIR__ . '/../model/AddContact.php');
require_once(__DIR__ . '/../model/DeleteContact.php');

function jsonResponse($success, $message, $data = null, $code = 200) {
    http_response_code($code);
    echo json_encode([
        'success' => $success,
        'message' => $message,
        'data' => $data
    ]);
    exit;
}

$action = $_GET['action'] ?? '';

try {
    switch ($action) {
        case 'uploadCsv':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                jsonResponse(false, 'Método HTTP no permitido, debe ser POST', null, 405);
            }
            if (!isset($_FILES['csvFile']) || $_FILES['csvFile']['error'] !== UPLOAD_ERR_OK) {
                jsonResponse(false, 'Archivo CSV no enviado o error en la carga', null, 400);
            }
            $csvModel = new CsvModel();
            $result = $csvModel->processCsv($_FILES['csvFile']['tmp_name'], $_FILES['csvFile']['name']);
            jsonResponse($result['success'], $result['message']);
            break;

        case 'addContact':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                jsonResponse(false, 'Método HTTP no permitido, debe ser POST', null, 405);
            }
            $addContact = new AddContact();
            $result = $addContact->addContact($_POST);
            jsonResponse($result['success'], $result['message']);
            break;

        case 'deleteContact':
            if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
                jsonResponse(false, 'Método HTTP no permitido, debe ser POST', null, 405);
            }
            if (empty($_POST['nombre'])) {
                jsonResponse(false, 'Parámetro "nombre" es requerido', null, 400);
            }
            $deleteContact = new DeleteContact();
            $result = $deleteContact->deleteContact($_POST['nombre']);
            jsonResponse($result['success'], $result['message']);
            break;

        default:
            jsonResponse(false, 'Acción no válida', null, 400);
    }
} catch (Exception $e) {
    jsonResponse(false, 'Error interno: ' . $e->getMessage(), null, 500);
}

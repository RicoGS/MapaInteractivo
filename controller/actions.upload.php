<?php
header('Content-Type: application/json');

require_once __DIR__ . '/../model/csv.model.php';

if ($_GET['action'] === 'uploadCsv') {
    // Suponiendo que recibes el archivo vía $_FILES o algún otro método
    $csvModel = new CsvModel();
    // Por ejemplo, puedes llamar:
    // $response = $csvModel->processCsv($uploadedFilePath, $uploadedFileName);
    // echo json_encode($response;)
}
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Método incorrecto']);
    exit;
}

if (!isset($_FILES['csv_file']) || $_FILES['csv_file']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'message' => 'No se ha subido ningún archivo']);
    exit;
}

$uploadedFilePath = $_FILES['csv_file']['tmp_name'];
$uploadedFileName = $_FILES['csv_file']['name'];

// Llamar al modelo para procesar el CSV
$csvModel = new CsvModel();
$response = $csvModel->processCsv($uploadedFilePath, $uploadedFileName);

echo json_encode($response);
exit;


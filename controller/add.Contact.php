<?php
// Cabecera JSON
header('Content-Type: application/json');
// Asegúrate de requerir el archivo correcto que define la clase AddContact
require_once "/../model/Contact.models.php"; // <- NO "csv.controller.php", eso no tiene la clase
// Validar que se recibe la acción correcta
if (isset($_GET['action']) && $_GET['action'] === 'addContact') {
    // Leer los datos del cuerpo como JSON
    $data = json_decode(file_get_contents('php://input'), true);
    // Validar que se recibieron datos
    if (!$data) {
        echo json_encode(['success' => false, 'message' => 'Datos JSON inválidos o vacíos']);
        exit;
    }
    // Instanciar y procesar
    $addContact = new ManagementContact();
    $response = $addContact->addContact($data);
    // Devolver la respuesta
    echo json_encode($response);
    exit;
}
// Si no se pasa 'action=addContact'
echo json_encode(['success' => true, 'message' => 'Contacto agregado']);
echo json_encode(['success' => false, 'message' => 'Algo salió mal']);
exit;


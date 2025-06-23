<?php
require_once __DIR__ . '/../model/forms.models.php';

$id = $_GET['id'] ?? 0;
$contacto = FormsModel::getContactoById($id);
echo json_encode($contacto ?: []);
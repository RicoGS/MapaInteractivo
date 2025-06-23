<?php
require_once __DIR__ . '/../model/forms.models.php';

$term = $_GET['term'] ?? '';
$results = FormsModel::buscarContactos($term);
echo json_encode(['results' => $results]);

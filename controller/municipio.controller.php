<?php
require_once __DIR__ . '/../model/forms.models.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['municipio'])) {
    $municipio = $_GET['municipio'];
    $resultado = FormsModel::getDataByMunicipio($municipio);
    header('Content-Type: application/json');
    echo json_encode($resultado);
    exit;
}
<?php
// controller/filtrarContactos.php
require_once __DIR__ . '/../model/Contact.model.php';

$distrito = isset($_POST['distrito']) ? $_POST['distrito'] : 'All';
$clasificacion = isset($_POST['clasificacion']) ? $_POST['clasificacion'] : 'All';

$contactManager = new ManagementContact();
$contactos = $contactManager->filtrarContactos($distrito, $clasificacion);

echo json_encode($contactos);

<?php
require_once 'model\conection.php';

$db = (new Conexion())->conectar();

// Simula usuarios con contraseñas sin hashear
$usuarios = [
    ['username' => 'saul', 'password' => 'rico'],
    ['username' => 'admin', 'password' => '1234']
];

foreach ($usuarios as $usuario) {
    $hashedPassword = password_hash($usuario['password'], PASSWORD_DEFAULT);

    $stmt = $db->prepare("UPDATE usuario SET password = :password WHERE username = :username");
    $stmt->bindParam(':password', $hashedPassword);
    $stmt->bindParam(':username', $usuario['username']);
    $stmt->execute();
}

echo "Contraseñas actualizadas correctamente.";
<?php
require_once __DIR__ . '/../model/forms.models.php';

class FormsController {
    static public function login($username, $password) {
        $user = FormsModel::getUserByUsername($username);

        if ($user && password_verify($password, $user['password'])) {
            // Verificar que la sesión no esté ya iniciada
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }

            $_SESSION['username'] = $user['username'];
            $_SESSION['idUser'] = $user['idUser'];
            $_SESSION['rol'] = $user['rol'];

            return [
                'success' => true,
                'message' => 'Inicio de sesión exitoso',
                'username' => $user['username'],
                'rol' => $user['rol']
            ];
        }

        return ['success' => false, 'message' => 'Usuario o contraseña incorrectos'];
    }
}

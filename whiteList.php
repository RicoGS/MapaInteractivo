<?php

session_start();

$rol = $_SESSION['rol'] ?? null;
$paginasPermitidas = [];

if ($rol === 'admin') {
    $paginasPermitidas = [
        'inicio' => ['titulo' => 'Inicio', 'icono' => 'fas fa-home'],
        'settings' => ['titulo' => 'Configuraciones', 'icono' => 'fas fa-cogs'],
        'reportes' => ['titulo' => 'Reportes', 'icono' => 'fas fa-chart-bar']
    ];
} elseif ($rol === 'alumno') {
    $paginasPermitidas = [
        'inicio' => ['titulo' => 'Inicio', 'icono' => 'fas fa-home'],
        'evaluacion' => ['titulo' => 'Evaluación', 'icono' => 'fas fa-edit'],
    ];
}

echo "<title> Mapa interactivo - $pagina</title>";

$rutaPagina = "view/pages/{$pagina}.php";

// Handle user access
if (!isset($_SESSION['logged_in'])) {
    // Redirect non-logged users to login page except for allowed public pages
    if ($pagina !== 'login') {
        header('Location: login');
        exit;
    } else {
        includeLogin($pagina);
    }
} else {
    if (array_key_exists($pagina, $paginasPermitidas)) {
        includeUserPages($rutaPagina, $paginasPermitidas);
    } else {
        includeError404();
    }
}
function includeUserPages($rutaPagina, $paginasPermitidas) {
    include "view/css.php";
    include 'view/pages/navs/header.php';
    
    if (file_exists($rutaPagina) && is_file($rutaPagina)) {
        include $rutaPagina;
    } else {
        includeError404();
    }
    include 'view/js.php';
}

function includeLogin($pagina) {
    include "view/pages/auth/$pagina.php";
}

function includeError404() {
    header("Location: 404");
    exit;
}
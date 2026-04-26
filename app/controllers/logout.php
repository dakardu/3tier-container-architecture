<?php
require_once __DIR__ . '/../config/routes.php';

// Iniciar sesión por si no está iniciada
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vaciar variables
$_SESSION = [];

// Destruir sesión en servidor (Redis)
session_destroy();

// 🔴 ELIMINAR COOKIE (CLAVE)
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Redirigir
header("Location: " . BASE_URL);
exit();

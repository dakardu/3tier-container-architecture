<?php

// PRODUCCIÓN
ini_set('display_errors', 0);
error_reporting(E_ALL);

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

require_once __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

// 🔥 Cargar .env correctamente (ruta absoluta y segura)
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad(); // no rompe si no existe

// 🔥 Obtener variables (forma robusta REAL)
function envOrFail($key) {
    $value = $_ENV[$key] ?? $_SERVER[$key] ?? getenv($key);

    if ($value === false || $value === null || $value === '') {
        error_log("Falta variable de entorno: $key");
        die("Error interno del servidor.");
    }

    return $value;
}

// Variables DB
$host = envOrFail('DB_HOST');
$user = envOrFail('DB_USER');
$password = envOrFail('DB_PASSWORD');
$dbname = envOrFail('DB_NAME');

try {
    $conexion = new mysqli($host, $user, $password, $dbname, 3306);
    $conexion->options(MYSQLI_OPT_SSL_VERIFY_SERVER_CERT, false); // Desactivar verificación SSL (solo si es necesario)
    
    // Timeout
    $conexion->options(MYSQLI_OPT_CONNECT_TIMEOUT, 5);

    // Charset
    $conexion->set_charset("utf8mb4");

} catch (Exception $e) {
    error_log("Error DB: " . $e->getMessage());
    die("No se pudo conectar a la base de datos.");
}

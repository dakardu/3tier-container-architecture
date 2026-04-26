<?php
require_once(dirname(__DIR__) . '/../config/routes.php');

if (!isset($_SESSION['rol_usuario']) || ($_SESSION['rol_usuario'] !== 'usuario' && $_SESSION['rol_usuario'] !== 'admin')) {
    header("Location:" . ACCESO_DENEGADO_URL);
    exit();
}

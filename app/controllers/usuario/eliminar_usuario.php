<?php
require_once(dirname(__DIR__, 2) . '/config/conexion.php');
require_once(dirname(__DIR__, 2) . '/config/routes.php');

$id = $_GET['id'] ?? '';
if ($id) {
    $query = $conexion->prepare("DELETE FROM usuarios WHERE id = ?");
    $query->bind_param("i", $id);
    $query->execute();
    $query->close();
}
header('Location: ' . ADMIN_URL . '?eliminado=' . $id);
exit();
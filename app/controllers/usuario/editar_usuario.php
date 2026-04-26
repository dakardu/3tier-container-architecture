<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once(dirname(__DIR__, 2) . '/config/conexion.php');
require_once(dirname(__DIR__, 2) . '/config/routes.php');

// Redirigir si el método no es POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: " . ADMIN_URL);
    exit();
}

// Recoger y sanear los datos del formulario
$id = filter_input(INPUT_POST, 'id', FILTER_VALIDATE_INT);
$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_SPECIAL_CHARS);
$nombre = filter_input(INPUT_POST, 'nombre', FILTER_SANITIZE_SPECIAL_CHARS);
$correo = filter_input(INPUT_POST, 'correo', FILTER_VALIDATE_EMAIL);
$rol = filter_input(INPUT_POST, 'rol', FILTER_SANITIZE_SPECIAL_CHARS);

// Validar los datos
$errors = [];
if (empty($id)) {
    $errors[] = "ID de usuario no válido.";
}
if (empty($nombre)) {
    $errors[] = "El nombre completo es obligatorio.";
}
if (empty($correo)) {
    $errors[] = "El correo electrónico no es válido.";
}
if (empty($rol) || !in_array($rol, ['admin', 'usuario'])) {
    $errors[] = "El rol seleccionado no es válido.";
}

// Si hay errores, redirigir de vuelta con los errores
if (!empty($errors)) {
    $_SESSION['form_errors'] = $errors;
    $_SESSION['form_data'] = $_POST;
    header("Location: " . EDITAR_FORMULARIO_URL . "?id=" . $id);
    exit();
}

// Si no hay errores, proceder con la actualización
try {
    $query = $conexion->prepare("UPDATE usuarios SET username = ?, nombre = ?, correo = ?, rol = ? WHERE id = ?");
    $query->bind_param("ssssi", $username, $nombre, $correo, $rol, $id);
    
    if ($query->execute()) {
        $_SESSION['success_message'] = "Usuario actualizado correctamente.";
    } else {
        throw new Exception("Error al actualizar el usuario.");
    }
    $query->close();
} catch (Exception $e) {
    $_SESSION['form_errors'] = ["Error en la base de datos: " . $e->getMessage()];
    $_SESSION['form_data'] = $_POST;
    header("Location: " . EDITAR_FORMULARIO_URL . "?id=" . $id);
    exit();
}

// Redirigir al panel de administración
header("Location: " . ADMIN_URL);
exit();
?>

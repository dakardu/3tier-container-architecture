<?php
require_once(dirname(__DIR__, 2) . '/config/conexion.php');
require_once(dirname(__DIR__, 2) . '/config/routes.php');

// Función para redirigir con un mensaje
function redirect_with_message($type, $message, $location = null) {
    $_SESSION[$type] = $message;
    
    if ($location === null) {
        $location = USER_PROFILE_URL;
    }
    
    header('Location: ' . $location);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    redirect_with_message('password_error', 'Acceso no permitido.');
}

$user_id = $_SESSION['id'] ?? null;
if (!$user_id) {
    redirect_with_message('password_error', 'No se ha identificado al usuario.');
}

$current_password = $_POST['current_password'];
$new_password = $_POST['new_password'];
$confirm_password = $_POST['confirm_password'];

// Validaciones básicas
if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
    redirect_with_message('password_error', 'Todos los campos son obligatorios.');
}

if (strlen($new_password) < 8) {
    redirect_with_message('password_error', 'La nueva contraseña debe tener al menos 8 caracteres.');
}

if ($new_password !== $confirm_password) {
    redirect_with_message('password_error', 'Las nuevas contraseñas no coinciden.');
}

try {
    $query = $conexion->prepare("SELECT password FROM usuarios WHERE id = ?");
    $query->bind_param("i", $user_id);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows === 0) {
        redirect_with_message('password_error', 'Usuario no encontrado.');
    }
    $user = $result->fetch_assoc();

    if (password_verify($current_password, $user['password'])) {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_query = $conexion->prepare("UPDATE usuarios SET password = ? WHERE id = ?");
        $update_query->bind_param("si", $hashed_password, $user_id);
        
        if ($update_query->execute()) {
            // Comprobar el rol del usuario para la redirección
            if (isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] === 'admin') {
                redirect_with_message('password_success', 'Contraseña actualizada correctamente.', ADMIN_URL);
            } else {
                redirect_with_message('password_success', 'Contraseña actualizada correctamente.', USER_PANEL_URL);
            }
        } else {
            throw new Exception("No se pudo actualizar la contraseña.");
        }
    } else {
        redirect_with_message('password_error', 'La contraseña actual es incorrecta.');
    }
} catch (Exception $e) {
    redirect_with_message('password_error', 'Error del servidor: ' . $e->getMessage());
}
?>

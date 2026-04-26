<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__) . '/config/conexion.php');
require_once(dirname(__DIR__) . '/config/routes.php');

// Función para redirigir con un mensaje de error de registro
function redirect_with_register_error($message) {
    $_SESSION['register_error'] = $message;
    // Guardar los datos del formulario para repoblar los campos
    $_SESSION['form_data'] = $_POST;
    header("Location: " . REGISTER_URL);
    exit();
}

function sanitizar($data) {
    return htmlspecialchars(trim($data));
}

$username = sanitizar($_POST['username'] ?? '');
$nombre = sanitizar($_POST['nombre'] ?? '');
$email = sanitizar($_POST['email'] ?? '');
$password = $_POST['password'] ?? '';

if(empty($username) || empty($nombre) || empty($email) || empty($password)) {
    redirect_with_register_error("Todos los campos son obligatorios.");
}

// 1. Comprobar si el username o el correo ya existen
$check_query = $conexion->prepare("SELECT id FROM usuarios WHERE username = ? OR correo = ?");
$check_query->bind_param("ss", $username, $email);
$check_query->execute();
$result = $check_query->get_result();

if ($result->num_rows > 0) {
    redirect_with_register_error("El nombre de usuario o el correo electrónico ya están en uso.");
}
$check_query->close();


// 2. Si no existen, proceder con la inserción
$password_segura = password_hash($password, PASSWORD_DEFAULT);
$rol = 'usuario'; // Asignar rol por defecto

$query = $conexion->prepare("INSERT INTO usuarios (username, nombre, correo, password, rol) VALUES (?, ?, ?, ?, ?)");
$query->bind_param("sssss", $username, $nombre, $email, $password_segura, $rol);

if ($query->execute()) {
    // Limpiar datos de formulario en sesión si el registro es exitoso
    unset($_SESSION['form_data'], $_SESSION['register_error']);

    // Iniciar sesión para el nuevo usuario
    $_SESSION['id'] = $query->insert_id;
    $_SESSION['username'] = $username;
    $_SESSION['rol_usuario'] = $rol;
    $_SESSION['nombre'] = $nombre;

    header("Location: " . USER_PANEL_URL);
    exit();
} else {
    // Error de base de datos genérico
    redirect_with_register_error("Error al registrar el usuario. Por favor, inténtelo de nuevo.");
}
$query->close();
?>

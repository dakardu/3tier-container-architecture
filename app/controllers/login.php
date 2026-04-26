<?php
// No iniciar la sesión aquí, ya se inicia en index.php
// session_start(); 

// Las rutas y la conexión a la BD ya no son necesarias aquí, se gestionan en los archivos que incluyen este.
// Sin embargo, para mantener la compatibilidad si se llama directamente, las dejamos pero con @ para suprimir errores si ya están definidas.
@require_once(dirname(__DIR__) . '/config/conexion.php');
@require_once(dirname(__DIR__) . '/config/routes.php');

// --- Lógica del controlador de Login ---

// Comprobar si la solicitud es de tipo POST para procesar el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    error_log("--- INICIO PROCESO DE LOGIN ---");
    error_log("Datos POST recibidos: " . print_r($_POST, true));
    
    // Función para redirigir con un mensaje de error
    function redirect_with_error($message) {
        $_SESSION['login_error'] = $message;
        // Redirigir de vuelta a la página de login para mostrar el error
        header("Location: " . LOGIN_URL);
        exit();
    }

    // Validar que la conexión a la BD exista
    if (!isset($conexion)) {
        redirect_with_error("Error de conexión a la base de datos.");
    }

    $correo = $_POST['email'] ?? '';
    $contraseña = $_POST['password'] ?? '';

    if (empty($correo) || empty($contraseña)) {
        error_log("Error: Correo o contraseña vacíos.");
        redirect_with_error("Por favor, introduce tu correo y contraseña.");
    }

    try {
        $query = $conexion->prepare("SELECT id, username, nombre, correo, password, rol FROM usuarios WHERE correo = ?");
        if (!$query) {
            error_log("❌ Error en prepare(): " . $conexion->error);
            redirect_with_error("Error en la consulta SQL.");
        }
        
        $query->bind_param("s", $correo);
        $query->execute();
        $result = $query->get_result();

        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            error_log("Usuario encontrado: " . $usuario['correo']);
            
            if (password_verify($contraseña, $usuario['password'])) {
                error_log("Contraseña correcta para el usuario: " . $usuario['correo']);
                unset($_SESSION['login_error']);
                $_SESSION['id'] = $usuario['id'];
                $_SESSION['rol_usuario'] = $usuario['rol'];
                $_SESSION['username'] = $usuario['username'];
                $_SESSION['nombre_usuario'] = $usuario['nombre'];

                if ($usuario['rol'] === 'admin') {
                    error_log("Redirigiendo al panel de administrador.");
                    header("Location: " . ADMIN_URL);
                } else {
                    error_log("Redirigiendo al panel de usuario.");
                    header("Location: " . USER_PANEL_URL);
                }
                exit();
            } else {
                error_log("Error: Contraseña incorrecta para el usuario: " . $correo);
                redirect_with_error("La contraseña es incorrecta.");
            }
        } else {
            error_log("Error: No se encontró ningún usuario con el correo: " . $correo);
            redirect_with_error("No se encontró ningún usuario con ese correo.");
        }
        $query->close();
        $conexion->close();
    } catch (Exception $e) {
        error_log("❌ Error en login.php: " . $e->getMessage());
        redirect_with_error("Ha ocurrido un error en el servidor.");
    }

}
?>

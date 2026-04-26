<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Incluir el archivo de configuración de rutas
include_once __DIR__ . '/../config/routes.php';

// Configurar REDIS para sesiones (si se ha configurado)
ini_set('session.save_handler', 'redis');
ini_set('session.save_path', 'tcp://redis:6379');

// Iniciar la sesión para mantener el estado del usuario
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// --- Enrutador simple ---
// Obtener la URL solicitada, eliminando la ruta base y los parámetros GET.
$request_uri = strtok($_SERVER['REQUEST_URI'], '?');
$request_path = str_replace(rtrim(BASE_URL, '/'), '', $request_uri);
$request_path = trim($request_path, '/');

// Variable para almacenar la ruta de la vista a cargar
$view_to_load = null;

// Procesar la lógica del controlador ANTES de enviar cualquier salida HTML
switch ($request_path) {
    case 'login':
        // El controlador de login solo maneja la acción (POST).
        // Si es GET, simplemente se cargará la vista más adelante.
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once CONTROLLERS_PATH . '/login.php';
        }
        break;

    case 'logout':
        include_once CONTROLLERS_PATH . '/logout.php';
        break;

    case 'registro':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once CONTROLLERS_PATH . '/registrar.php';
        }
        break;

    case 'admin':
        // Lógica de admin (si la hay)
        break;

    case 'usuario/editar':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once CONTROLLERS_PATH . '/usuario/editar_usuario.php';
        }
        break;

    case 'usuario/eliminar':
        include_once CONTROLLERS_PATH . '/usuario/eliminar_usuario.php';
        break;

    case 'usuario/cambiar_password':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            include_once CONTROLLERS_PATH . '/usuario/cambiar_password.php';
        }
        break;
}

// Incluir el encabezado común de la página DESPUÉS de la lógica de controladores
include_once HEADER_PATH;

// Cargar la vista correspondiente según la ruta
switch ($request_path) {
    case '':
    case 'index':
    case 'index.php':
        echo '<div id="main-content"><div class="welcome-box"><h1>Bienvenid@s a Netservices</h1><p class="lead text-light">Contenido de bienvenida</p></div></div>';
        break;

    case 'login':
        include_once VIEWS_PATH . '/login.php';
        break;

    case 'registro':
        include_once VIEWS_PATH . '/registro.php';
        break;

    case 'admin':
        include_once ROOT_PATH . '/admin/admin.php';
        break;
    
    case 'admin/editar_formulario':
        include_once ROOT_PATH . '/admin/editar_formulario.php';
        break;

    case 'usuario/panel':
        include_once VIEWS_PATH . '/usuario/panel_usuario.php';
        break;
    
    case 'usuario/perfil':
        include_once VIEWS_PATH . '/usuario/perfil.php';
        break;

    case 'acceso_denegado':
        include_once VIEWS_PATH . '/acceso_denegado.php';
        break;

    // Los casos de 'logout', 'usuario/editar', 'usuario/eliminar' no necesitan cargar una vista aquí
    // porque redirigen o son manejados por otras vistas.

    default:
        // Si no se encuentra la ruta, mostrar un error 404
        http_response_code(404);
        echo '<div class="container text-center mt-5"><h1 class="text-danger">Error 404</h1><p>Página no encontrada.</p></div>';
        break;
}
?>

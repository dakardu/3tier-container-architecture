<?php
// Define la ruta base de la aplicación.
define('BASE_URL', '/');

// --- URLs para la aplicación (rutas que manejará el router) ---
define('LOGIN_URL', BASE_URL . 'login');
define('LOGOUT_URL', BASE_URL . 'logout');
define('REGISTER_URL', BASE_URL . 'registro');
define('ADMIN_URL', BASE_URL . 'admin');
define('USER_PANEL_URL', BASE_URL . 'usuario/panel');
define('USER_PROFILE_URL', BASE_URL . 'usuario/perfil');
define('ACCESO_DENEGADO_URL', BASE_URL . 'acceso_denegado');

// --- URLs de acción para formularios (apuntan a las mismas rutas) ---
define('LOGIN_ACTION_URL', LOGIN_URL);
define('ACCION_REGISTRAR_URL', REGISTER_URL);

// --- URLs de assets (servidos directamente desde /public) ---
define('CSS_ADMIN', BASE_URL . 'assets/css/stilo-admin.css');
define('CSS_GENERAL', BASE_URL . 'assets/css/stilo-general.css');
define('LOGO_URL', BASE_URL . 'assets/img/logo.png');

// --- Constantes de rutas de sistema de archivos para includes ---
define('ROOT_PATH', dirname(__DIR__));
define('HEADER_PATH', ROOT_PATH . '/header.php');
define('CONTROLLERS_PATH', ROOT_PATH . '/controllers');
define('VIEWS_PATH', ROOT_PATH . '/views');

// --- URLs para operaciones específicas (se añadirán al router) ---
// Nota: Estas URLs necesitarán sus propias reglas en el router de index.php
define('EDITAR_USUARIO_URL', BASE_URL . 'usuario/editar');
define('ELIMINAR_USUARIO_URL', BASE_URL . 'usuario/eliminar');
define('CHANGE_PASSWORD_URL', BASE_URL . 'usuario/cambiar_password');
define('EDITAR_FORMULARIO_URL', BASE_URL . 'admin/editar_formulario');
?>

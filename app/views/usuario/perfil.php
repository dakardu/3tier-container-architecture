<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__, 2) . '/config/routes.php');
require_once(dirname(__DIR__, 2) . '/controllers/usuario/require_usuario.php');
require_once(dirname(__DIR__, 2) . '/config/conexion.php');

if (!isset($_SESSION['id'])) {
    // Redirigir si el ID de usuario no está en la sesión
    header('Location: ' . LOGIN_URL);
    exit;
}

$user_id = $_SESSION['id'];
$query = $conexion->prepare("SELECT username, nombre, correo FROM usuarios WHERE id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();
$user = $result->fetch_assoc();

?>

<div class="container mt-5">
    <h2 class="text-center text-light mb-4">Mi Perfil</h2>

	<p style="color: orange;">
        	Servidor: <?php echo gethostname(); ?>
    	</p>

    <div class="card bg-dark text-light p-4 shadow">
        <div class="card-body">
            <p><strong>Username:</strong> <?php echo htmlspecialchars($user['username']); ?></p>
            <p><strong>Nombre:</strong> <?php echo htmlspecialchars($user['nombre']); ?></p>
            <p><strong>Correo:</strong> <?php echo htmlspecialchars($user['correo']); ?></p>
        </div>
    </div>

    <h3 class="text-center text-light mt-5 mb-4">Cambiar Contraseña</h3>

    <?php
    if (isset($_SESSION['password_error'])) {
        echo '<div class="alert alert-danger">' . htmlspecialchars($_SESSION['password_error']) . '</div>';
        unset($_SESSION['password_error']);
    }
    if (isset($_SESSION['password_success'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['password_success']) . '</div>';
        unset($_SESSION['password_success']);
    }
    ?>

    <form action="<?php echo CHANGE_PASSWORD_URL; ?>" method="post" autocomplete="off">
        <div class="mb-3">
            <label for="username" class="form-label">Usuario</label>
            <input type="text" name="username" class="form-control" value="<?php echo htmlspecialchars($user['username']); ?>" readonly>
        </div>
        <div class="mb-3">
            <label for="current_password" class="form-label">Contraseña Actual</label>
            <input type="password" name="current_password" class="form-control" autocomplete="current-password" required>
        </div>
        <div class="mb-3">
            <label for="new_password" class="form-label">Nueva Contraseña</label>
            <input type="password" name="new_password" class="form-control" autocomplete="new-password" required>
        </div>
        <div class="mb-3">
            <label for="confirm_password" class="form-label">Confirmar Nueva Contraseña</label>
            <input type="password" name="confirm_password" class="form-control" autocomplete="new-password" required>
        </div>
        <button type="submit" class="btn btn-primary w-100">Cambiar Contraseña</button>
    </form>
</div>

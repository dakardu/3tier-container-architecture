<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once __DIR__ . '/../config/conexion.php';
require_once __DIR__ . '/../config/routes.php';

$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($id === 0) {
    die("ID de usuario no válido.");
    exit();
}

$query = $conexion->prepare("SELECT username, nombre, correo, rol FROM usuarios WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if($result->num_rows === 0) {
    die("Usuario no encontrado.");
    exit();
}
$usuario = $result->fetch_assoc();

// Recuperar datos del formulario de la sesión si existen
$form_data = $_SESSION['form_data'] ?? [];
$form_errors = $_SESSION['form_errors'] ?? [];

// Limpiar la sesión para que los mensajes no se repitan
unset($_SESSION['form_data'], $_SESSION['form_errors']);

// Sobrescribir los datos del usuario con los datos del formulario si hubo un error
$username = $form_data['username'] ?? $usuario['username'];
$nombre = $form_data['nombre'] ?? $usuario['nombre'];
$correo = $form_data['correo'] ?? $usuario['correo'];
$rol = $form_data['rol'] ?? $usuario['rol'];
?>
<div class="container mt-5">
    <div class="card bg-dark text-light shadow-sm">
        <div class="card-header">
            <h2 class="mb-0">Editar Usuario: <?php echo htmlspecialchars($nombre); ?></h2>
            </div>
            <div class="card-body">
                <?php if (!empty($form_errors)): ?>
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            <?php foreach ($form_errors as $error): ?>
                                <li><?php echo htmlspecialchars($error); ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?php echo EDITAR_USUARIO_URL; ?>" method="POST">
                    <input type="hidden" name="id" value="<?php echo $id; ?>">

                    <div class="mb-3">
                        <label for="username" class="form-label">Nombre de Usuario</label>
                        <input type="text" class="form-control" name="username" id="username" value="<?php echo htmlspecialchars($username); ?>">
                    </div>

                    <div class="mb-3">
                        <label for="nombre" class="form-label">Nombre Completo</label>
                        <input type="text" class="form-control" name="nombre" id="nombre" value="<?php echo htmlspecialchars($nombre); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="correo" class="form-label">Correo Electrónico</label>
                        <input type="email" class="form-control" name="correo" id="correo" value="<?php echo htmlspecialchars($correo); ?>" required>
                    </div>

                    <div class="mb-3">
                        <label for="rol" class="form-label">Rol</label>
                        <select class="form-select" name="rol" id="rol">
                            <option value="admin" <?php if ($rol === 'admin') echo 'selected'; ?>>Administrador</option>
                            <option value="usuario" <?php if ($rol === 'usuario') echo 'selected'; ?>>Usuario</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">Actualizar Usuario</button>
                </form>
            </div>
        </div>
    </div>

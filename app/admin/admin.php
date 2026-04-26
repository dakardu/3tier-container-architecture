<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__) . '/config/routes.php');
require_once(dirname(__DIR__) . '/controllers/admin/require_admin.php');
require_once(dirname(__DIR__) . '/config/conexion.php');

?>
<div class="admin-panel-wrapper">
    <div id="main-content">
        <h2 class="text-light mb-4">
            <i class="fas fa-users-cog me-2"></i> Usuarios registrados
        </h2>

        <div class="card bg-dark text-light p-4 shadow admin-card">
            <table class="table table-dark table-hover table-admin align-middle">
            <thead class="table-secondary">
                <tr>
                <th>ID</th>
                <th>Username</th>
                <th>Nombre</th>
                <th>Correo</th>
                <th>Rol</th>
                <th>Fecha</th>
                <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $query = $conexion->query('SELECT id, username, nombre, correo, rol, creado_en FROM usuarios');
                while ($row = $query->fetch_assoc()) {
                    echo '<tr>'
                        . '<td>' . $row['id'] . '</td>'
                        . '<td>' . $row['username'] . '</td>'
                        . '<td>' . $row['nombre'] . '</td>'
                        . '<td>' . $row['correo'] . '</td>'
                        . '<td><span class="badge bg-' . ($row['rol'] === 'admin' ? 'danger' : 'secondary') . '">' . ucfirst($row['rol']) . '</span></td>'
                        . '<td>' . $row['creado_en'] . '</td>'
                        . '<td>'
                        . '<a href="' . EDITAR_FORMULARIO_URL . '?id=' . $row['id'] . '" class="btn btn-sm btn-warning me-1" title="Editar">'
                            . '<i class="fas fa-edit"></i></a>'
                        . '<a href="' . ELIMINAR_USUARIO_URL . '?id=' . $row['id'] . '" class="btn btn-sm btn-danger" title="Eliminar" onclick="return confirm(\'¿Eliminar este usuario?\');">'
                            . '<i class="fas fa-trash-alt"></i></a>'
                        . '</td>'
                    . '</tr>';
                }
                $conexion->close();
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

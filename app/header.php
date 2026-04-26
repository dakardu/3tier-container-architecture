<?php
// La sesión y las rutas ahora se gestionan en public/index.php
?>
<!DOCTYPE html>
<html lang="es">
  <head>
      <meta charset="UTF-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>NetServices</title>
      <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
      <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600&display=swap" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
      <link rel="stylesheet" href="<?php echo CSS_GENERAL; ?>">
      <link rel="stylesheet" href="<?php echo CSS_ADMIN; ?>">
    </head>
  <body>
    <!-- Barra de navegación estilizada -->
    <div id="nav-container">
      <nav class="custom-navbar">
        <div class="d-flex align-items-center gap-3">
          <img src="<?php echo LOGO_URL; ?>" alt="Logo Netservices" class="logo">
          <span class="fw-bold text-primary fs-4">NetServices</span>
        </div>
        <div>
          <?php if (isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 'admin'): ?>
            <a href="<?php echo ADMIN_URL; ?>"><i class="fas fa-tools"></i> Panel Admin</a>
            <a href="<?php echo USER_PROFILE_URL; ?>"><i class="fas fa-user-circle"></i> Mi Perfil</a>
            <a href="<?php echo LOGOUT_URL; ?>"><i class="fas fa-right-from-bracket"></i> Cerrar sesión</a>

          <?php elseif (isset($_SESSION['rol_usuario']) && $_SESSION['rol_usuario'] == 'usuario'): ?>
            <a href="<?php echo USER_PANEL_URL; ?>"><i class="fas fa-tachometer-alt"></i> Panel de Usuario</a>
            <a href="<?php echo USER_PROFILE_URL; ?>"><i class="fas fa-user-circle"></i> Mi Perfil</a>
            <a href="<?php echo LOGOUT_URL; ?>"><i class="fas fa-right-from-bracket"></i> Cerrar sesión</a>

          <?php else: ?>
            <a href="<?php echo BASE_URL; ?>"><i class="fas fa-house"></i> Inicio</a>
            <a href="<?php echo LOGIN_URL; ?>"><i class="fas fa-right-to-bracket"></i> Sign in</a>
            <?php if (!isset($_SESSION['id'])): ?>
              <a href="<?php echo REGISTER_URL; ?>"><i class="fas fa-user-plus"></i> Registrar</a>
            <?php endif; ?>
          <?php endif; ?>
        </div>
      </nav>
    </div>

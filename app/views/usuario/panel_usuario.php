<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once(dirname(__DIR__, 2) . '/config/routes.php');

?>

<div class="container mt-5">
    <?php
    if (isset($_SESSION['password_success'])) {
        echo '<div class="alert alert-success">' . htmlspecialchars($_SESSION['password_success']) . '</div>';
        unset($_SESSION['password_success']);
    }
    ?>
    <h2>Zona de Usuario</h2>
    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username'] ?? '', ENT_QUOTES); ?></p>
</div>
